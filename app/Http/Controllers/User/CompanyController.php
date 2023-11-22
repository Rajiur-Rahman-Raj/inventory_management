<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\SalesCenterStoreRequest;
use App\Http\Traits\Notify;
use App\Models\Badge;
use App\Models\Company;
use App\Http\Traits\Upload;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\SalesCenter;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockInDetails;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use App\Http\Traits\StockInTrait;

class CompanyController extends Controller
{
    use Upload, Notify, StockInTrait;

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

        $data['stockLists'] = Stock::with('item:id,name')
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->whereHas('item', function ($q) use ($search) {
                    $q->whereRaw("name REGEXP '[[:<:]]{$search['name']}[[:>:]]'");
                });
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

    public function manageSales()
    {
        $admin = $this->user;
        $data['items'] = Item::where('company_id', $admin->active_company_id)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit')
            ->latest()
            ->get();

        $data['customers'] = Customer::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->latest()->get();

        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        return view($this->theme . 'user.manageSales.index', $data);
    }


    public function getSelectedItems(Request $request)
    {
        $admin = $this->user;

        $query = Stock::with('item:id,name,image')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit')
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

}
