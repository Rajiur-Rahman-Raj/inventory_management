<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\SalesCenterStoreRequest;
use App\Http\Traits\Notify;
use App\Models\Badge;
use App\Models\CartItems;
use App\Models\Company;
use App\Http\Traits\Upload;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SalesCenter;
use App\Models\SalesItem;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockInDetails;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use App\Http\Traits\StockInTrait;
use App\Http\Traits\storeSalesTrait;

class CompanyController extends Controller
{
    use Upload, Notify, StockInTrait, storeSalesTrait;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function index()
    {
        $user = $this->user;

        $data['companies'] = Company::where('user_id', $user->id)->get();

        $data['allBadges'] = Badge::with('details')->where('status', 1)->orderBy('sort_by', 'ASC')->get();
        return view($this->theme . 'user.company.index', $data);
    }

    public function createCompany()
    {
        return view($this->theme . 'user.company.create');
    }

    public function companyStore(CompanyStoreRequest $request)
    {
        $authId = auth()->id();
        try {
            DB::beginTransaction();
            $company = new Company();
            $company->user_id = $authId;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->trade_id = $request->trade_id;

            if ($request->hasFile('logo')) {
                try {
                    $company->logo = $this->uploadImage($request->logo, config('location.companyLogo.path'), config('location.companyLogo.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $company->save();
            DB::commit();

            return back()->with('success', 'Company create successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function companyEdit($id)
    {
        $user = $this->user;
        $data['singleCompany'] = Company::where('user_id', $user->id)->findOrFail($id);
        return view($this->theme . 'user.company.edit', $data);
    }

    public function companyUpdate(CompanyUpdateRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            $company = Company::findOrFail($id);
            $company->name = $request->name;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->trade_id = $request->trade_id;

            if ($request->hasFile('logo')) {
                try {
                    $company->logo = $this->uploadImage($request->logo, config('location.companyLogo.path'), config('location.companyLogo.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $company->save();
            DB::commit();

            return back()->with('success', 'Company Update successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function activeCompany($id)
    {
        $user = $this->user;

        $company = Company::where('user_id', $user->id)->findOrFail($id);

        $user = User::findOrFail($user->id);
        $user->active_company_id = $id;
        $user->save();
        $company_name = $company->name;
        return back()->with('success', $company_name . ' Activated Successfully!');
    }

    public function companyActive($id)
    {
        $user = $this->user;

        $company = Company::where('user_id', $user->id)->findOrFail($id);

        $user = User::findOrFail($user->id);
        $user->active_company_id = $id;
        $user->save();
        $company_name = $company->name;
        return back()->with('success', $company_name . ' Activated Successfully!');
    }

    public function inactiveCompany($id)
    {
        $user = $this->user;

        $company = Company::where('user_id', $user->id)->findOrFail($id);

        $user = User::findOrFail($user->id);
        $user->active_company_id = null;
        $user->save();
        $company_name = $company->name;
        return back()->with('success', $company_name . ' Inactive Successfully!');
    }

    public function deleteCompany($id)
    {
        $user = $this->user;
        $company = Company::with('salesCenter.user')->where('user_id', $user->id)->findOrFail($id);

        if (count($company->salesCenter) > 0) {
            foreach ($company->salesCenter as $salesCenter) {
                $salesCenter->user->delete();
                $salesCenter->delete();
            }
        }

        $company->delete();
        return back()->with('success', 'Company Deleted Successfully');
    }

    public function salesCenterList(Request $request)
    {
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();
        $loggedInUser = $this->user;


        $data['centerLists'] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union', 'activeCompanySalesCenter')
            ->when(isset($search['name']), function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search['name'] . '%');
            })
            ->when(isset($search['code']), function ($query) use ($search) {
                $query->where('code', 'LIKE', '%' . $search['code'] . '%');
            })
            ->when(isset($search['owner']), function ($query) use ($search) {
                $query->where('id', $search['owner']);
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('created_at', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->where('company_id', optional($loggedInUser->activeCompany)->id)->paginate(config('basic.paginate'));

        return view($this->theme . 'user.salesCenter.index', $data);
    }

    public function createSalesCenter()
    {
        $data['allDivisions'] = Division::where('status', 1)->get();
        return view($this->theme . 'user.salesCenter.create', $data);
    }

    public function storeSalesCenter(SalesCenterStoreRequest $request)
    {
        $loggedInUser = $this->user;
        try {
            DB::beginTransaction();

            $user = new User();

            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            $salesCenter = new SalesCenter();
            $salesCenter->user_id = $user->id;
            $salesCenter->company_id = optional($loggedInUser->activeCompany)->id;
            $salesCenter->name = $request->name;
            $salesCenter->code = $request->code;
            $salesCenter->owner_name = $request->owner_name;
            $salesCenter->national_id = $request->national_id;
            $salesCenter->trade_id = $request->trade_id;
            $salesCenter->division_id = $request->division_id;
            $salesCenter->district_id = $request->district_id;
            $salesCenter->upazila_id = $request->upazila_id;
            $salesCenter->union_id = $request->union_id;
            $salesCenter->address = $request->address;

            if ($request->hasFile('image')) {
                try {
                    $salesCenter->image = $this->uploadImage($request->image, config('location.salesCenter.path'), config('location.salesCenter.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $salesCenter->save();
            DB::commit();

            $this->sendMailSms($user, $type = 'CREATE_SALES_CENTER', [
                'center_name' => optional($user->salesCenter)->name,
                'owner_name' => optional($user->salesCenter)->owner_name,
                'code' => optional($user->salesCenter)->code,
                'email' => $user->email,
                'password' => $request->password,
            ]);

            return back()->with('success', 'Sales Center Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function salesCenterDetails($id)
    {
        $data['salesCenter'] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union')->findOrFail($id);
        return view($this->theme . 'user.salesCenter.details', $data);
    }

    public function deleteSalesCenter($id)
    {
        $salesCenter = SalesCenter::with('user')->findOrFail($id);
        optional($salesCenter->user)->delete();
        $salesCenter->delete();

        return back()->with('success', 'Sales Center Deleted Successfully!');

    }

    public function salesCenterEdit($id)
    {
        $data['singleSalesCenter '] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union')->findOrFail($id);
        return view($this->theme . 'user.salesCenter.edit', $data);
    }

    public function itemList(Request $request)
    {
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $loggedInUser = $this->user;
        $data['itemLists'] = Item::where('company_id', optional($loggedInUser->activeCompany)->id)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search['name'] . '%');
            })
            ->when(isset($search['coil']), function ($query) use ($search) {
                return $query->where('coil', 'LIKE', '%' . $search['coil'] . '%');
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('created_at', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->where('status', 1)->paginate(config('basic.paginate'));
        return view($this->theme . 'user.items.index', $data);
    }

    public function itemStore(Request $request)
    {
        $loggedInUser = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        if ($request->name == null) {
            return back()->with('error', 'Item name is required');
        }

        try {

            $rules = [
                'name' => 'required|string|max:255',
                'unit' => 'nullable',
            ];

            $message = [
                'name.required' => __('Item name field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $item = new Item();
            $item->name = $request->name;
            $item->unit = $request->unit;
            $item->company_id = optional($loggedInUser->activeCompany)->id;

            if ($request->hasFile('image')) {
                try {
                    $item->image = $this->uploadImage($request->image, config('location.itemImage.path'), config('location.itemImage.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $item->save();

            DB::beginTransaction();
            return back()->with('success', 'Item Created Successfully');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function updateItem(Request $request, $id)
    {

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        if ($request->name == null) {
            return back()->with('error', 'Item name is required');
        }

        try {
            $rules = [
                'name' => 'required|string|max:255',
                'unit' => 'nullable',
            ];

            $message = [
                'name.required' => __('Item name field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $item = Item::findOrFail($id);

            $item->name = $request->name;
            $item->unit = $request->unit;

            if ($request->hasFile('image')) {
                try {
                    $item->image = $this->uploadImage($request->image, config('location.itemImage.path'), config('location.itemImage.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $item->save();

            return back()->with('success', 'Item Update Successfully');

        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong');
        }

    }

    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Item Deleted Successfully!');
    }

    public function stockList(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $data['allItems'] = Item::where('company_id', $admin->active_company_id)->where('status', 1)->get();

        $data['stockLists'] = Stock::with('item:id,name')
            ->when(isset($search['item_id']), function ($query) use ($search) {
                return $query->whereHas('item', function ($q) use ($search) {
                    $q->where('id', $search['item_id']);
                });
            })
            ->when(isset($search['stock_check']) && $search['stock_check'] == 'available_in_stock', function ($q2) use ($search) {
                return $q2->where('quantity', '>', 0);
            })
            ->when(isset($search['stock_check']) && $search['stock_check'] == 'out_of_stock', function ($q2) use ($search) {
                return $q2->where('quantity', '<=', 0);
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('last_stock_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('last_stock_date', [$fromDate, $toDate]);
            })
            ->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->latest()
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'stock_date', 'last_stock_date')
            ->paginate(config('basic.paginate'));
        return view($this->theme . 'user.stock.index', $data);
    }

    public function addStock()
    {
        $loggedInUser = $this->user;
        $data['allItems'] = Item::where('company_id', optional($loggedInUser->activeCompany)->id)->get();
        return view($this->theme . 'user.stock.create', $data);
    }

    public function stockStore(Request $request)
    {

        $loggedInUser = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'stock_date' => 'required',
        ];

        $message = [
            'stock_date.required' => __('stock date is required'),
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {

            DB::beginTransaction();

            $stockIn = new StockIn();
            $stockIn->company_id = $loggedInUser->active_company_id;
            $stockIn->stock_date = $request->stock_date;
            $stockIn->total_cost = $request->sub_total;

            $stockIn->save();

            $this->storeStockInDetails($request, $stockIn);

            $this->storeStocks($request, $loggedInUser);

            DB::commit();

            return back()->with('success', 'Item stock added successfully!s');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }

    }

    public function stockDetails($item = null, $id = null)
    {
        $data['stock'] = Stock::select('id', 'item_id', 'last_stock_date')->findOrFail($id);

        $data['singleStockDetails'] = StockInDetails::with('item')->where('item_id', $data['stock']->item_id)->latest()->get();
        $data['totalItemCost'] = $data['singleStockDetails']->sum('total_unit_cost');

        return view($this->theme . 'user.stock.details', $data, compact('item'));
    }

    public function getSelectedItemUnit(Request $request)
    {
        $unit = DB::table('items')
            ->where('id', $request->itemId)
            ->value('unit');

        return response()->json(['unit' => $unit]);
    }

    public function customerList(Request $request)
    {
        $admin = $this->user;

        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $data['customers'] = Customer::with('division:id,name', 'district:id,name', 'upazila:id,name', 'union:id,name')
            ->when(isset($search['name']), function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search['name'] . '%');
            })
            ->when(isset($search['email']), function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . $search['email'] . '%');
            })
            ->when(isset($search['phone']), function ($query) use ($search) {
                $query->where('phone', 'LIKE', '%' . $search['phone'] . '%');
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('created_at', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->select('id', 'division_id', 'district_id', 'upazila_id', 'union_id', 'name', 'email', 'phone', 'national_id', 'address', 'created_at')
            ->where('company_id', $admin->active_company_id)
            ->latest()->paginate(config('basic.paginate'));

        return view($this->theme . 'user.customer.index', $data);
    }

    public function createCustomer()
    {
        $data['allDivisions'] = Division::where('status', 1)->get();
        return view($this->theme . 'user.customer.create', $data);
    }

    public function customerStore(Request $request)
    {
        $loggedInUser = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'required|unique:customers,phone',
            'national_id' => 'nullable',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'union_id' => 'nullable|exists:unions,id',
            'address' => 'required',
        ];

        $messages = [
            'name.required' => __('Name is required'),
            'email.email' => __('Invalid email format'),
            'email.unique' => __('Email is already taken'),
            'phone.required' => __('Phone number is required'),
            'phone.unique' => __('Phone number is already taken'),
            'division_id.exists' => __('Invalid division selected'),
            'district_id.exists' => __('Invalid district selected'),
            'upazila_id.exists' => __('Invalid upazila selected'),
            'union_id.exists' => __('Invalid union selected'),
            'address.required' => __('Address is required'),
        ];

        $validate = Validator::make($purifiedData, $rules, $messages);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            DB::beginTransaction();

            $customer = new Customer();

            $customer->name = $request->name;
            $customer->company_id = $loggedInUser->active_company_id;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->national_id = $request->national_id;
            $customer->division_id = $request->division_id;
            $customer->district_id = $request->district_id;
            $customer->upazila_id = $request->upazila_id;
            $customer->union_id = $request->union_id;
            $customer->address = $request->address;
            $customer->save();

            DB::commit();

            return back()->with('success', 'Customer Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function customerDetails($id)
    {
        $admin = $this->user;
        $data['customer'] = Customer::with('division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->findOrFail($id);
        return view($this->theme . "user.customer.details", $data);
    }

    public function customerEdit($id)
    {
        $admin = $this->user;
        $data['customer'] = Customer::with('division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->findOrFail($id);
        $data['divisions'] = Division::select('id', 'name')->get();
        $data['districts'] = District::select('id', 'name')->get();
        $data['upazilas'] = Upazila::select('id', 'name')->get();
        $data['unions'] = Union::select('id', 'name')->get();
        return view($this->theme . 'user.customer.edit', $data);
    }

    public function customerUpdate(Request $request, $id)
    {
        $loggedInUser = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'phone' => 'required',
            'national_id' => 'nullable',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'union_id' => 'nullable|exists:unions,id',
            'address' => 'required',
        ];

        $messages = [
            'name.required' => __('Name is required'),
            'email.email' => __('Invalid email format'),
            'phone.required' => __('Phone number is required'),
            'division_id.exists' => __('Invalid division selected'),
            'district_id.exists' => __('Invalid district selected'),
            'upazila_id.exists' => __('Invalid upazila selected'),
            'union_id.exists' => __('Invalid union selected'),
            'address.required' => __('Address is required'),
        ];

        $validate = Validator::make($purifiedData, $rules, $messages);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($id);

            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->national_id = $request->national_id;
            $customer->division_id = $request->division_id;
            $customer->district_id = $request->district_id;
            $customer->upazila_id = $request->upazila_id;
            $customer->union_id = $request->union_id;
            $customer->address = $request->address;
            $customer->save();

            DB::commit();

            return back()->with('success', 'Customer Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return back()->with('success', "Customer Deleted Successfully!");
    }

    public function salesList(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();

        $sales_date = Carbon::parse($request->sales_date);
        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        $data['salesLists'] = Sale::with('salesCenter')
            ->when(isset($search['invoice_id']), function ($q2) use ($search) {
                return $q2->where('invoice_id', $search['invoice_id']);
            })
            ->when(isset($search['sales_center_id']) && $search['sales_center_id'] != 'all', function ($q) use ($search) {
                $q->whereRaw("sales_center_id REGEXP '[[:<:]]{$search['sales_center_id']}[[:>:]]'");
            })
            ->when(isset($search['sales_date']), function ($q2) use ($sales_date) {
                return $q2->whereDate('created_at', $sales_date);
            })
            ->when(isset($search['status']) && $search['status'] != 'all', function ($q) use ($search) {
                $q->whereRaw("payment_status REGEXP '[[:<:]]{$search['status']}[[:>:]]'");
            })
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.manageSales.salesList', $data);
    }

    public function salesDetails($id)
    {
        $admin = $this->user;
        $data['singleSalesDetails'] = Sale::with('salesCenter', 'customer', 'salesItems')->where('company_id', $admin->active_company_id)->findOrFail($id);

        return view($this->theme . 'user.manageSales.salesDetails', $data);
    }

    public function salesItem()
    {
        $admin = $this->user;
        $data['items'] = Item::where('company_id', $admin->active_company_id)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->latest()
            ->get();

        $data['customers'] = Customer::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->latest()->get();

        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        $data['cartItems'] = CartItems::with('item')->where('company_id', $admin->active_company_id)->get();

        $data['subTotal'] = $data['cartItems']->sum('cost');

        return view($this->theme . 'user.manageSales.salesItem', $data);
    }

    public function updateItemUnitPrice(Request $request, $id)
    {
        $admin = $this->user;
        $filter_item_id = $request->filter_item_id;
        $stock = Stock::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->select('id', 'selling_price')->findOrFail($id);
        $stock->selling_price = $request->selling_price;

        $stock->save();
        return back()->with('success', 'Item Price Updated Successfully!')->with('filterItemId', $filter_item_id);
    }

    public function getSelectedItems(Request $request)
    {
        $admin = $this->user;

        $query = Stock::with('item:id,name,image')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id');

        if ($request->id !== "all") {
            $query->where('item_id', $request->id);
        }

        $stocks = $query->latest()->get()->map(function ($stock) {
            $item = $stock->item;
            $item->image = getFile(config('location.itemImage.path') . optional($stock->item)->image);
            return $stock;
        });

        return response()->json(['stocks' => $stocks]);
    }

    public function getSelectedCustomer(Request $request)
    {
        $admin = $this->user;

        $customer = Customer::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->select('id', 'name', 'phone', 'address')->findOrFail($request->id);

        return response()->json(['customer' => $customer]);
    }

    public function getSelectedSalesCenter(Request $request)
    {
        $admin = $this->user;
        $salesCenter = SalesCenter::with('user:id,phone')->where('company_id', $admin->active_company_id)->select('id', 'user_id', 'owner_name', 'address', 'code')->findOrFail($request->id);
        return response()->json(['salesCenter' => $salesCenter]);
    }

    public function storeCartItems(Request $request)
    {
        $admin = $this->user;
        $stock = $request->data;

        $cartItem = CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->where('stock_id', $stock['id'])
            ->where('item_id', $stock['item_id'])
            ->first();


        if ($cartItem && $cartItem['quantity'] >= $stock['quantity']) {
            $status = false;
            $message = "This item is out of stock";
        } else {
            CartItems::updateOrInsert(
                [
                    'company_id' => $admin->active_company_id,
                    'stock_id' => $stock['id'],
                    'item_id' => $stock['item_id'],
                ],
                [
                    'cost_per_unit' => $stock['selling_price'],
                    'quantity' => DB::raw('quantity + 1'),
                    'cost' => DB::raw('quantity * cost_per_unit'),
                    'created_at' => $cartItem ? $cartItem->created_at : Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            $status = true;
            $message = "Cart item added successfully";
        }

        $cartItems = CartItems::with('item', 'sale')->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();

        return response()->json([
            'cartItems' => $cartItems,
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function storeSalesCartItems(Request $request)
    {
        $admin = $this->user;
        $salesItem = $request->data;

        $cartItem = CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->where('stock_id', $salesItem['stock_id'])
            ->where('item_id', $salesItem['item_id'])
            ->first();


        CartItems::updateOrInsert(
            [
                'company_id' => $admin->active_company_id,
                'stock_id' => $salesItem['stock_id'],
                'item_id' => $salesItem['item_id'],
            ],
            [
                'sales_id' => $request->salesId,
                'cost_per_unit' => $salesItem['cost_per_unit'],
                'quantity' => $salesItem['item_quantity'],
                'cost' => $salesItem['item_price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $cartItems = CartItems::with('item')->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();

        return response()->json([
            'cartItems' => $cartItems,
        ]);
    }

    public function updateCartItems(Request $request)
    {
        $admin = $this->user;

        $stock = Stock::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->select('id', 'quantity')
            ->findOrFail($request->stockId);

        $oldPlusNewQuantity = $request->oldBuyItemQuantity + $stock->quantity;

        if ($request->oldBuyItemQuantity && ($request->cartQuantity > $oldPlusNewQuantity)) {
            $status = false;
            $message = "This item is out of stock";
            $stockQuantity = $oldPlusNewQuantity;
        } else {
            $cartItem = CartItems::where([
                'company_id' => $admin->active_company_id,
                'stock_id' => $request->stockId,
                'item_id' => $request->itemId,
            ])->first();

            if ($cartItem && $request->cartQuantity > ($request->oldBuyItemQuantity ? $oldPlusNewQuantity : $stock->quantity)) {
                $status = false;
                $message = "This item is out of stock";
                $stockQuantity = $oldPlusNewQuantity;
            } else {
                CartItems::updateOrInsert(
                    [
                        'company_id' => $admin->active_company_id,
                        'stock_id' => $request->stockId,
                        'item_id' => $request->itemId,
                    ],
                    [
                        'quantity' => $request->cartQuantity,
                        'cost' => DB::raw('quantity * cost_per_unit'),
                        'updated_at' => Carbon::now()
                    ]
                );

                $status = true;
                $message = "Cart item added successfully";
                $stockQuantity = null;
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'stockQuantity' => $stockQuantity,
        ]);
    }

    public function clearCartItems()
    {
        $admin = $this->user;
        CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->delete();

        return back()->with('success', 'Cart items deleted successfully!');
    }

    public function clearSaleCartItems()
    {
        $admin = $this->user;
        CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->delete();

        // Return a response (you can customize this based on your needs)
        return response()->json(['message' => 'Sale cart items cleared successfully']);
    }

    public function clearSingleCartItem(Request $request)
    {
        $admin = $this->user;
        CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->findOrFail($request->cartId)
            ->delete();

        $cartItems = CartItems::with('item')->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();

        return response()->json([
            'cartItems' => $cartItems,
            'status' => true,
            'message' => "Cart item deleted successfully",
        ]);
    }

    public function clearSingleReturnCartItem(Request $request)
    {
        $admin = $this->user;
        $cart = CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->findOrFail($request->cartId);

        SalesItem::where('sales_id', $cart->sales_id)->where('stock_id', $cart->stock_id)->where('item_id', $cart->item_id)->delete();

        $stock = Stock::where('company_id', $admin->active_company_id)->where('item_id', $cart->item_id)->first();

        $stock->quantity = $cart->quantity + $stock->quantity;
        $stock->save();

        $cart->delete();


        $cartItems = CartItems::with('item')->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();


        return response()->json([
            'cartItems' => $cartItems,
            'status' => true,
            'message' => "Cart item deleted successfully",
        ]);
    }

    public function salesOrderStore(Request $request)
    {

        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));


        try {
            $rules = [
                'items' => 'nullable',
                'payment_date' => 'required',
                'payment_note' => 'nullable',
            ];

            $message = [
                'payment_date.required' => 'The payment date field is required.',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }


            DB::beginTransaction();
            $sale = new Sale();
            $salesCenter = SalesCenter::where('company_id', $admin->active_company_id)->select('id', 'code')->findOrFail($request->sales_center_id);
            $invoiceId = mt_rand(1000000, 9999999);

            $due_or_change_amount = (float)floor($request->due_or_change_amount);
            $sale->company_id = $admin->active_company_id;
            $sale->sales_center_id = $request->sales_center_id;
            $sale->customer_id = $request->customer_id;
            $sale->sub_total = $request->sub_total;
            $sale->discount_parcent = ($request->discount_parcent ? $request->discount_parcent : 0);
            $sale->discount = $request->discount_amount;
            $sale->total_amount = $request->total_amount;
            $sale->customer_paid_amount = $due_or_change_amount <= 0 ? $request->total_amount : $request->customer_paid_amount;
            $sale->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
            $sale->payment_date = $request->payment_date;
            $sale->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
            $sale->payment_note = $request->payment_note;
            $sale->invoice_id = $salesCenter->code . '-' . $invoiceId;
            $items = $this->storeSalesItems($request, $sale);
            $sale->save();

            $this->storeSalesItemsInSalesItemModel($request, $sale);

            foreach ($items as $item) {
                $stock = Stock::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->select('id', 'quantity')->where('item_id', $item['item_id'])->first();
                $stock->quantity = (int)$stock->quantity - (int)$item['item_quantity'];
                $stock->save();
            }

            CartItems::where('company_id', $admin->active_company_id)
                ->whereNull('sales_center_id')
                ->delete();

            DB::commit();
            return redirect()->route('user.salesInvoice', $sale->id)->with('success', 'Order confirmed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function salesOrderUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'payment_date' => 'required',
            'payment_note' => 'nullable',
        ];

        $message = [
            'payment_date.required' => 'The payment date field is required.',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $due_or_change_amount = (float)floor($request->due_or_change_amount);
        $admin = $this->user;
        $sale = Sale::where('company_id', $admin->active_company_id)->findOrFail($id);

        $sale->customer_paid_amount = $due_or_change_amount <= 0 ? $sale->total_amount : (float)$request->customer_paid_amount + (float)$sale->customer_paid_amount;
        $sale->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
        $sale->payment_date = $request->payment_date;
        $sale->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
        $sale->payment_note = $request->payment_note;

        $sale->save();

        return back()->with('success', 'Due payment complete successfully');
    }

    public function salesInvoiceUpdate(Request $request, $id)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        try {
            $rules = [
                'items' => 'nullable',
                'payment_date' => 'required',
                'payment_note' => 'nullable',
            ];

            $message = [
                'payment_date.required' => 'The payment date field is required.',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();
            $sale = Sale::where('company_id', $admin->active_company_id)->findOrFail($id);

            $due_or_change_amount = (float)floor($request->due_or_change_amount);
            $sale->sub_total = $request->sub_total;
            $sale->discount_parcent = $request->discount_parcent;
            $sale->discount = $request->discount_amount;
            $sale->total_amount = $request->total_amount;
            $sale->customer_paid_amount = $due_or_change_amount <= 0 ? $request->total_amount : $request->customer_paid_amount;
            $sale->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
            $sale->payment_date = $request->payment_date;
            $sale->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
            $sale->payment_note = $request->payment_note;
            $this->storeSalesItems($request, $sale);
            $sale->save();

            $this->updateSalesItemsInSalesItemModel($request, $sale);

            CartItems::where('company_id', $admin->active_company_id)
                ->where('sales_id', $sale->id)
                ->whereNull('sales_center_id')
                ->delete();

            DB::commit();
            return redirect()->route('user.salesInvoice', $sale->id)->with('success', 'Return Order confirmed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function salesInvoice($id)
    {
        $admin = $this->user;
        $data['singleSalesDetails'] = Sale::with('company', 'salesCenter.user', 'salesCenter.division', 'salesCenter.district', 'salesCenter.upazila', 'customer', 'customer.division', 'customer.district', 'customer.upazila')->where('company_id', $admin->active_company_id)->findOrFail($id);

        return view($this->theme . 'user.manageSales.salesInvoice', $data);
    }

    public function salesReturn()
    {
        $admin = $this->user;
        $data['sales'] = Sale::with('salesCenter.user', 'customer', 'salesItems.sale')->where('company_id', $admin->active_company_id)->latest()->paginate(config('basic.paginate'));


        $data['items'] = Item::where('company_id', $admin->active_company_id)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->latest()
            ->get();

        $data['customers'] = Customer::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->latest()->get();

        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        $data['cartItems'] = CartItems::with('item')->where('company_id', $admin->active_company_id)->get();

        $data['subTotal'] = $data['cartItems']->sum('cost');
        return view($this->theme . 'user.manageReturn.salesReturnItem', $data);
    }


    public function returnSales($id){
        $admin = $this->user;
        // first delete previous cart items when return any product to customers.
        CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->delete();

        // now we need particular sales item for return to customer.
        $data['sale'] = Sale::with('salesCenter.user', 'customer', 'salesItems.sale')->where('company_id', $admin->active_company_id)->findOrFail($id);


        // store sales item into cart items table
        foreach($data['sale']->salesItems as $salesItem){
            CartItems::updateOrInsert(
                [
                    'company_id' => $admin->active_company_id,
                    'stock_id' => $salesItem['stock_id'],
                    'item_id' => $salesItem['item_id'],
                ],
                [
                    'sales_id' => $id,
                    'cost_per_unit' => $salesItem['cost_per_unit'],
                    'quantity' => $salesItem['item_quantity'],
                    'cost' => $salesItem['item_price'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }

        $data['cartItems'] = CartItems::with('item')->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();

        $data['subTotal'] = $data['cartItems']->sum('cost');

        $data['items'] = Item::where('company_id', $admin->active_company_id)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->latest()
            ->get();

        return view($this->theme . 'user.manageSales.returnsalesItem', $data);
    }

    public function returnSalesOrder(Request $request, $id){
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));
//        dd($purifiedData);
        try {
            $rules = [
                'items' => 'nullable',
                'return_date' => 'required',
                'return_note' => 'nullable',
            ];

            $message = [
                'return_date.required' => 'return date field is required.',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();
            $due_or_change_amount = (float)floor($request->due_or_change_amount);


            $sale = Sale::with('salesItems')->where('company_id', $admin->active_company_id)->findOrFail($id);
            $sale->sub_total = $request->sub_total;
            $sale->discount_parcent = (isset($request->discount_parcent) ? $request->discount_parcent : 0);
            $sale->discount = $request->discount_amount;
            $sale->total_amount = $request->total_amount;
            $sale->customer_paid_amount = $due_or_change_amount >= 0 ? $request->total_amount : ((float)floor($request->previous_paid) + (float)floor($request->customer_paid_amount));
            $sale->due_amount = $due_or_change_amount >= 0 ? 0 : $due_or_change_amount;
            $sale->payment_date = $request->return_date;
            $sale->payment_note = $request->return_note;
            $sale->payment_status = $due_or_change_amount >= 0 ? 1 : 0;
            $items = $this->storeSalesItems($request, $sale);
            $sale->save();

            $this->updateSalesItems($request, $sale);

            CartItems::where('company_id', $admin->active_company_id)
                ->whereNull('sales_center_id')
                ->delete();

            DB::commit();
            return redirect()->route('user.salesInvoice', $sale->id)->with('success', 'Return Order confirmed successfully!');

        }catch (\Exception $exception){
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }


    public function selectedSalesOrOrder(Request $request)
    {
        $admin = $this->user;
        if ($request->salesOrOrderValue == 'sales') {
            $data['stocks'] = Stock::with('item:id,name,image')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')
                ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
                ->latest()
                ->get()->map(function ($stock) {
                    $item = $stock->item;
                    $item->image = getFile(config('location.itemImage.path') . optional($stock->item)->image);
                    return $stock;
                });

            return response()->json(['stocks' => $data['stocks'], 'status' => 'stocks']);
        } else {
            $data['sales'] = Sale::with('salesCenter.user', 'customer', 'salesItems')->where('company_id', $admin->active_company_id)->latest()->get()
                ->map(function ($sale) {
                    $calesCenter = $sale->salesCenter;
                    $calesCenter->image = getFile(config('location.salesCenter.path') . optional($sale->salesCenter)->image);
                    $sale->order_date = customDate($sale->created_at);
                    return $sale;
                });

            return response()->json(['sales' => $data['sales'], 'status' => 'sales']);
        }

    }


    public function singleSalesOrder(Request $request)
    {
//        return $request->invoiceId;
        $admin = $this->user;
//        $query = Sale::with('salesCenter', 'customer', 'salesItems')->where('company_id', $admin->active_company_id);

        if ($request->invoiceId) {
            $sales = Sale::with('salesCenter', 'customer', 'salesItems')->where('company_id', $admin->active_company_id)->where('invoice_id', $request->invoiceId)->latest()->get()
                ->map(function ($sale) {
                    $calesCenter = $sale->salesCenter;
                    $calesCenter->image = getFile(config('location.salesCenter.path') . optional($sale->salesCenter)->image);
                    $sale->order_date = customDate($sale->created_at);
                    return $sale;
                });
        } else {
            $sales = Sale::with('salesCenter.user', 'customer', 'salesItems')->where('company_id', $admin->active_company_id)->latest()->get()
                ->map(function ($sale) {
                    $calesCenter = $sale->salesCenter;
                    $calesCenter->image = getFile(config('location.salesCenter.path') . optional($sale->salesCenter)->image);
                    $sale->order_date = customDate($sale->created_at);
                    return $sale;
                });
        }

//        if (!$request->invoiceId) {
//            $query->where('invoice_id', $request->invoiceId);
//        }else{
//            $query = Sale::with('salesCenter', 'customer', 'salesItems')->where('company_id', $admin->active_company_id);
//        }

//        $sales = $query->latest()->get()
//            ->map(function ($sale) {
//                $calesCenter = $sale->salesCenter;
//                $calesCenter->image = getFile(config('location.salesCenter.path') . optional($sale->salesCenter)->image);
//                $sale->order_date = customDate($sale->created_at);
//                return $sale;
//            });


//        $admin = $this->user;
//        $data['sales'] = Sale::with('salesCenter', 'customer', 'salesItems')->where('company_id', $admin->active_company_id)->where('invoice_id', $request->invoiceId)->latest()->get()
//            ->map(function ($sale) {
//                $calesCenter = $sale->salesCenter;
//                $calesCenter->image = getFile(config('location.salesCenter.path') . optional($sale->salesCenter)->image);
//                $sale->order_date = customDate($sale->created_at);
//                return $sale;
//            });
//        return $sales;
        return response()->json(['sales' => $sales, 'status' => 'sales']);
    }

}
