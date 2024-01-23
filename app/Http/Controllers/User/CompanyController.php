<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\SalesCenterStoreRequest;
use App\Http\Traits\Notify;
use App\Http\Traits\RawItemPurchaseTrait;
use App\Models\AffiliateMember;
use App\Models\AffiliateMemberSalesCenter;
use App\Models\Badge;
use App\Models\CartItems;
use App\Models\Company;
use App\Http\Traits\Upload;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\Expense;
use Exception;
use App\Models\ExpenseCategory;
use App\Models\Item;
use App\Models\RawItem;
use App\Models\RawItemPurchaseIn;
use App\Models\RawItemPurchaseInDetails;
use App\Models\RawItemPurchaseStock;
use App\Models\Sale;
use App\Models\SalesCenter;
use App\Models\SalesItem;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockInDetails;
use App\Models\Supplier;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use App\Models\Wastage;
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
use function PHPUnit\Framework\isNull;

class CompanyController extends Controller
{
    use Upload, Notify, StockInTrait, storeSalesTrait, RawItemPurchaseTrait;

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


        $data['centerLists'] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union', 'company')
            ->when(isset($search['sales_center_id']), function ($query) use ($search) {
                $query->where('id', $search['sales_center_id']);
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
        $admin = $this->user;
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->owner_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->address = $request->owner_address;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('image')) {
                try {
                    $user->image = $this->uploadImage($request->image, config('location.user.path'), config('location.user.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $user->save();

            $salesCenter = new SalesCenter();
            $salesCenter->user_id = $user->id;
            $salesCenter->company_id = $admin->active_company_id;
            $salesCenter->name = $request->name;
            $salesCenter->code = $request->code;
            $salesCenter->national_id = $request->national_id;
            $salesCenter->trade_id = $request->trade_id;
            $salesCenter->division_id = $request->division_id;
            $salesCenter->district_id = $request->district_id;
            $salesCenter->upazila_id = $request->upazila_id;
            $salesCenter->union_id = $request->union_id;
            $salesCenter->center_address = $request->center_address;

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
            DB::rollBack();
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

    public function wastageList(Request $request)
    {
        $search = $request->all();
        $admin = $this->user;
        $data['rawItems'] = RawItem::where('company_id', $admin->active_company_id)->get();
        $data['wastageLists'] = Wastage::with('rawItem')
            ->when(isset($search['raw_item_id']), function ($query) use ($search) {
                $query->where('raw_item_id', $search['raw_item_id']);
            })
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));
        return view($this->theme . 'user.wastage.index', $data);
    }

    public function wastageStore(Request $request)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        try {
            $rules = [
                'raw_item_id' => 'required|exists:raw_items,id',
                'quantity' => 'required',
            ];

            $message = [
                'raw_item_id.required' => __('Item name field is required'),
                'quantity.required' => __('Quantity field is required'),
                'wastage_date.required' => __('Wastage Date is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $rawItemStock = RawItemPurchaseStock::where('company_id', $admin->active_company_id)->where('raw_item_id', $request->raw_item_id)->select('id', 'quantity')->first();

            DB::beginTransaction();
            $wastage = new Wastage();
            if ($rawItemStock->quantity > 0) {
                $wastage->company_id = $admin->active_company_id;
                $wastage->raw_item_id = $request->raw_item_id;
                $wastage->quantity = $request->quantity;
                $wastage->wastage_date = $request->wastage_date;
                $wastage->save();

                $rawItemStock->quantity = ($rawItemStock->quantity <= 0 ? 0 : $rawItemStock->quantity - $request->quantity);
                $rawItemStock->save();
            }


            DB::commit();
            return back()->with('success', 'Wastage added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteWastage(Request $request, $id)
    {
        $admin = $this->user;
        $wastage = Wastage::where('company_id', $admin->active_company_id)->findOrFail($id);
        $wastage->delete();
        return back()->with('success', 'Wastage Deleted Successfully');
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

            DB::beginTransaction();
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
            DB::commit();
            return back()->with('success', 'Item Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
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

    public function expenseCategory(Request $request)
    {
        $search = $request->all();
        $admin = $this->user;
        $data['expenseCategories'] = ExpenseCategory::where('company_id', $admin->active_company_id)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search['name'] . '%');
            })
            ->where('status', 1)->paginate(config('basic.paginate'));
        return view($this->theme . 'user.expense.category', $data);
    }

    public function expenseCategoryStore(Request $request)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        if ($request->name == null) {
            return back()->with('error', 'category name is required');
        }

        try {
            $rules = [
                'name' => 'required|string|max:255',
            ];

            $message = [
                'name.required' => __('Category name field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();
            $category = new ExpenseCategory();
            $category->company_id = $admin->active_company_id;
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return back()->with('success', 'Category Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function updateExpenseCategory(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        if ($request->name == null) {
            return back()->with('error', 'Category name is required');
        }

        try {
            $rules = [
                'name' => 'required|string|max:255',
                'unit' => 'nullable',
            ];

            $message = [
                'name.required' => __('Category name field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $category = ExpenseCategory::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return back()->with('success', 'Category Update Successfully');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteExpenseCategory($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category Deleted Successfully!');
    }

    public function expenseList(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $data['expenseCategories'] = ExpenseCategory::where('company_id', $admin->active_company_id)->where('status', 1)->get();

        $data['expenseList'] = Expense::with('expenseCategory:id,name')->where('company_id', $admin->active_company_id)
            ->when(isset($search['category_id']), function ($query) use ($search) {
                return $query->whereHas('expenseCategory', function ($q) use ($search) {
                    $q->where('id', $search['category_id']);
                });
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('created_at', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->where('status', 1)->paginate(config('basic.paginate'));


        return view($this->theme . 'user.expense.list', $data);
    }

    public function expenseListStore(Request $request)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        try {

            $rules = [
                'category_id' => 'required|exists:expense_categories,id',
                'amount' => 'required',
            ];

            $message = [
                'category_id.required' => __('Category field is required'),
                'amount.required' => __('Amount field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();

            $expense = Expense::firstOrNew([
                'company_id' => $admin->active_company_id,
                'category_id' => $request->category_id,
            ]);

            $expense->amount += $request->amount; // Increment the amount
            $expense->save();

            DB::commit();
            return back()->with('success', 'Expense Added Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function updateExpenseList(Request $request, $id)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        try {
            $rules = [
                'category_id' => 'required|exists:expense_categories,id',
                'amount' => 'required',
            ];

            $message = [
                'category_id.required' => __('Category field is required'),
                'amount.required' => __('Amount field is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();

            $expense = Expense::where('company_id', $admin->active_company_id)->findOrFail($id);
            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->save();

            DB::commit();
            return back()->with('success', 'Expense Update Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteExpenseList($id)
    {
        $admin = $this->user;
        $expense = Expense::where('company_id', $admin->active_company_id)->findOrFail($id);
        $expense->delete();
        return back()->with('success', 'Expense Deleted Successfully!');
    }

    public function stockList(Request $request)
    {
        $admin = $this->user;

        $search = $request->all();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $data['allItems'] = Item::where('status', 1)
        ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($q2) use ($admin) {
            $q2->where('company_id', $admin->active_company_id);
        })->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($q2) use ($admin) {
            $q2->where('company_id', $admin->salesCenter->company_id);
        })->where('status', 1)->get();


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
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($q2) use ($admin) {
                $q2->where('company_id', $admin->active_company_id)
                    ->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($q2) use ($admin) {
                $q2->where('company_id', $admin->salesCenter->company_id)
                    ->where('sales_center_id', $admin->salesCenter->id);
            })
            ->latest()
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'stock_date', 'last_stock_date')
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.stock.index', $data);
    }

    public function addStock()
    {
        $admin = $this->user;
        $data['items'] = Item::where('company_id', $admin->active_company_id)->get();
        $data['rawItems'] = RawItem::where('company_id', $admin->active_company_id)->get();
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

            return back()->with('success', 'Item stock added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
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
        $salesCenter = SalesCenter::with('user')->where('company_id', $admin->active_company_id)->select('id', 'user_id', 'name', 'center_address', 'code')->findOrFail($request->id);
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


            $this->storeAndUpdateStocks($request, $items, $admin);


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


    public function purchaseRawItemDueAmountUpdate(Request $request, $id)
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
        $purchaseRawItem = RawItemPurchaseIn::where('company_id', $admin->active_company_id)->findOrFail($id);

        $purchaseRawItem->paid_amount = $due_or_change_amount <= 0 ? $purchaseRawItem->total_price : (float)$request->paid_amount + (float)$purchaseRawItem->paid_amount;
        $purchaseRawItem->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
        $purchaseRawItem->payment_date = $request->payment_date;
        $purchaseRawItem->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
        $purchaseRawItem->payment_note = $request->payment_note;

        $purchaseRawItem->save();

        return back()->with('success', 'Due payment completed successfully');
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

    public function returnSales($id)
    {
        $admin = $this->user;
        // first delete previous cart items when return any product to customers.
        CartItems::where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->delete();

        // now we need particular sales item for return to customer.
        $data['sale'] = Sale::with('salesCenter.user', 'customer', 'salesItems.sale')->where('company_id', $admin->active_company_id)->findOrFail($id);


        // store sales item into cart items table
        foreach ($data['sale']->salesItems as $salesItem) {
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

    public function returnSalesOrder(Request $request, $id)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));
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

        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }


    // Suppliers Module
    public function suppliers(Request $request)
    {

        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $data['suppliers'] = Supplier::with('division:id,name', 'district:id,name', 'upazila:id,name', 'union:id,name')
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
            ->latest()
            ->paginate(config('basic.paginate'));


//        $data['customers'] = Customer::with('division:id,name', 'district:id,name', 'upazila:id,name', 'union:id,name')
//            ->when(isset($search['name']), function ($query) use ($search) {
//                $query->where('name', 'LIKE', '%' . $search['name'] . '%');
//            })
//            ->when(isset($search['email']), function ($query) use ($search) {
//                $query->where('email', 'LIKE', '%' . $search['email'] . '%');
//            })
//            ->when(isset($search['phone']), function ($query) use ($search) {
//                $query->where('phone', 'LIKE', '%' . $search['phone'] . '%');
//            })
//            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
//                return $q2->whereDate('created_at', '>=', $fromDate);
//            })
//            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
//                return $q2->whereBetween('created_at', [$fromDate, $toDate]);
//            })
//            ->select('id', 'division_id', 'district_id', 'upazila_id', 'union_id', 'name', 'email', 'phone', 'national_id', 'address', 'created_at')
//            ->where('company_id', $admin->active_company_id)
//            ->latest()->paginate(config('basic.paginate'));

        return view($this->theme . 'user.suppliers.index', $data);
    }

    public function createSupplier()
    {
        $data['allDivisions'] = Division::where('status', 1)->get();
        return view($this->theme . 'user.suppliers.create', $data);
    }

    public function supplierStore(Request $request)
    {
        $admin = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'required|unique:suppliers,phone',
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
            $supplier = new Supplier();

            $supplier->company_id = $admin->active_company_id;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->national_id = $request->national_id;
            $supplier->division_id = $request->division_id;
            $supplier->district_id = $request->district_id;
            $supplier->upazila_id = $request->upazila_id;
            $supplier->union_id = $request->union_id;
            $supplier->address = $request->address;
            $supplier->save();

            DB::commit();

            return back()->with('success', 'Supplier Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function supplierDetails($id)
    {
        $admin = $this->user;
        $data['supplier'] = Supplier::with('division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);
        return view($this->theme . "user.suppliers.details", $data);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return back()->with('success', "Supplier Deleted Successfully!");
    }

    public function supplierEdit($id)
    {
        $admin = $this->user;
        $data['supplier'] = Supplier::with('division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);
        $data['divisions'] = Division::select('id', 'name')->get();
        $data['districts'] = District::select('id', 'name')->get();
        $data['upazilas'] = Upazila::select('id', 'name')->get();
        $data['unions'] = Union::select('id', 'name')->get();
        return view($this->theme . 'user.suppliers.edit', $data);
    }

    public function supplierUpdate(Request $request, $id)
    {
        $admin = $this->user;
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
            $supplier = Supplier::findOrFail($id);

            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->national_id = $request->national_id;
            $supplier->division_id = $request->division_id;
            $supplier->district_id = $request->district_id;
            $supplier->upazila_id = $request->upazila_id;
            $supplier->union_id = $request->union_id;
            $supplier->address = $request->address;
            $supplier->save();

            DB::commit();

            return back()->with('success', 'Supplier Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function rawItemList(Request $request)
    {
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        $loggedInUser = $this->user;
        $data['itemLists'] = RawItem::where('company_id', optional($loggedInUser->activeCompany)->id)
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
        return view($this->theme . 'user.rawItems.index', $data);
    }


    public function rawItemStore(Request $request)
    {
        $loggedInUser = $this->user;

        if ($request->name == null) {
            return back()->with('error', 'Item name is required');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'unit' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png'
        ];

        $message = [
            'name.required' => __('Item name field is required'),
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {

            DB::beginTransaction();
            $rawItem = new RawItem();
            $rawItem->name = $request->name;
            $rawItem->unit = $request->unit;
            $rawItem->company_id = optional($loggedInUser->activeCompany)->id;

            if ($request->hasFile('image')) {
                try {
                    $rawItem->image = $this->uploadImage($request->image, config('location.rawItemImage.path'), config('location.rawItemImage.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $rawItem->save();
            DB::commit();
            return back()->with('success', 'Raw Item Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function updateRawItem(Request $request, $id)
    {
        if ($request->name == null) {
            return back()->with('error', 'Item name is required');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'unit' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png'
        ];

        $message = [
            'name.required' => __('Item name field is required'),
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            DB::beginTransaction();
            $item = RawItem::findOrFail($id);
            $item->name = $request->name;
            $item->unit = $request->unit;

            if ($request->hasFile('image')) {
                try {
                    $item->image = $this->uploadImage($request->image, config('location.rawItemImage.path'), config('location.rawItemImage.size'));
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $item->save();
            DB::commit();
            return back()->with('success', 'Item Update Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteRawItem($id)
    {
        $rawItem = RawItem::findOrFail($id);
        $rawItem->delete();
        return back()->with('success', 'Raw Item Deleted Successfully!');
    }

    public function purchaseRawItemList(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);

        $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->where('status', 1)->get();

        $data['purchasedItems'] = RawItemPurchaseIn::with('supplier')
            ->when(isset($search['supplier_id']), function ($query) use ($search) {
                return $query->where('supplier_id', $search['supplier_id']);
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('purchase_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('purchase_date', [$fromDate, $toDate]);
            })
            ->when(isset($search['payment_status']) && $search['payment_status'] == 'paid', function ($q2) use ($search) {
                return $q2->where('payment_status', 1);
            })
            ->when(isset($search['payment_status']) && $search['payment_status'] == 'due', function ($q2) use ($search) {
                return $q2->where('payment_status', 0);
            })
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));


        return view($this->theme . 'user.rawItems.purchaseRawItemList', $data);
    }

    public function rawItemPurchaseDetails($id)
    {
        $admin = $this->user;
        $data['singlePurchaseItem'] = RawItemPurchaseIn::with('supplier:id,name')->where('company_id', $admin->active_company_id)->findOrFail($id);
        $data['singlePurchaseItemDetails'] = RawItemPurchaseInDetails::with('rawItem:id,name')->where('raw_item_purchase_in_id', $id)->latest()->get();
        $data['totalItemCost'] = $data['singlePurchaseItemDetails']->sum('total_unit_cost');
        return view($this->theme . 'user.rawItems.purchaseRawItemDetails', $data);
    }

//    public function deletePurchaseRawItem($id)
//    {
//        $admin = $this->user;
//        $purchaseRawItem = RawItemPurchaseStock::where('company_id', $admin->active_company_id)->findOrFail($id);
//        $purchaseRawItem->delete();
//        return back()->with('success', 'Deleted Successfully!');
//    }


    public function purchaseRawItem()
    {
        $admin = $this->user;
        $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        $data['allItems'] = RawItem::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        return view($this->theme . 'user.rawItems.purchaseRawItem', $data);
    }

    public function storePurchaseItem(Request $request)
    {

        $admin = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required',
            'item_id' => 'required|exists:raw_items,id',
        ];

        $message = [
            'supplier_id.required' => __('Please select a supplier'),
            'purchase_date.required' => __('Purchase date is required'),
            'item_id.required' => __('Please select a item'),
        ];


        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            DB::beginTransaction();
            $purchaseIn = new RawItemPurchaseIn();
            $purchaseIn->company_id = $admin->active_company_id;
            $purchaseIn->supplier_id = $request->supplier_id;
            $purchaseIn->purchase_date = $request->purchase_date;
            $purchaseIn->sub_total = $request->sub_total;
            $purchaseIn->discount_percent = $request->discount_percentage ? $request->discount_percentage : 0;
            $purchaseIn->discount_amount = $request->discount_percentage ? (float)$request->sub_total - (float)$request->total_price : 0;
            $purchaseIn->total_price = $request->total_price;
            $purchaseIn->paid_amount = $request->paid_amount;
            $due_or_change_amount = (float)floor($request->due_or_change_amount);
            $purchaseIn->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
            $purchaseIn->payment_date = $request->payment_date;
            $purchaseIn->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
            $purchaseIn->payment_note = $request->payment_note;
            $purchaseIn->save();

            $this->storeRawItemPurchaseInDetails($request, $purchaseIn);

            $this->storeRawItemPurchaseStock($request, $purchaseIn, $admin);
            DB::commit();
            return back()->with('success', 'Raw items purchased successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }

    }

    public function purchaseRawItemStocks(Request $request)
    {

        $admin = $this->user;
        $search = $request->all();

        $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        $data['rawItems'] = RawItem::where('company_id', $admin->active_company_id)->where('status', 1)->get();

        $data['purchasedItems'] = RawItemPurchaseStock::with('rawItem')
            ->when(isset($search['item_id']), function ($query) use ($search) {
                return $query->where('raw_item_id', $search['item_id']);
            })
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.rawItems.purchaseRawItemStocks', $data);
    }

    public function getSelectedRawItemUnit(Request $request)
    {
        $unit = DB::table('raw_items')
            ->where('id', $request->itemId)
            ->value('unit');

        return response()->json(['unit' => $unit]);
    }

    public function affiliateMemberList()
    {
        $admin = $this->user;
        $data['allDivisions'] = Division::where('status', 1)->get();
        $data['affiliateMembers'] = AffiliateMember::with('salesCenter', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->latest()->paginate(config('basic.paginate'));
//        dd($data['affiliateMembers']);
        return view($this->theme . 'user.affiliate.index', $data);
    }

    public function createAffiliateMember()
    {
        $admin = $this->user;
        $data['allDivisions'] = Division::where('status', 1)->get();
        $data['saleCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        return view($this->theme . 'user.affiliate.create', $data);
    }

    public function affiliateMemberStore(Request $request)
    {

        $admin = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'sales_center_id' => 'required|exists:sales_centers,id',
            'member_name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:affiliate_members,email',
            'phone' => 'required|unique:affiliate_members,phone',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'union_id' => 'nullable|exists:unions,id',
            'member_national_id' => 'nullable',
            'member_commission' => 'nullable',
            'date_of_death' => 'nullable',
            'wife_name' => 'required|string|max:100',
            'wife_national_id' => 'nullable',
            'wife_commission' => 'nullable',
            'address' => 'required',
        ];

        $messages = [
            'sales_center_id.required' => __('Please select sales center'),
            'member_name.required' => __('Member Name is required'),
            'email.email' => __('Invalid email format'),
            'email.unique' => __('Email is already taken'),
            'phone.required' => __('Phone number is required'),
            'phone.unique' => __('Phone number is already taken'),
            'division_id.exists' => __('Invalid division selected'),
            'district_id.exists' => __('Invalid district selected'),
            'upazila_id.exists' => __('Invalid upazila selected'),
            'union_id.exists' => __('Invalid union selected'),
            'wife_name.required' => __('Member wife name is required'),
            'address.required' => __('Address is required'),
        ];


        $validate = Validator::make($purifiedData, $rules, $messages);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }


//        try {
        DB::beginTransaction();
        $member = new AffiliateMember();
        $member->company_id = $admin->active_company_id;
        $member->member_name = $request->member_name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->division_id = $request->division_id;
        $member->district_id = $request->district_id;
        $member->upazila_id = $request->upazila_id;
        $member->union_id = $request->union_id;
        $member->member_national_id = $request->member_national_id;
        $member->member_commission = $request->member_commission;
        $member->date_of_death = $request->date_of_death;
        $member->wife_name = $request->wife_name;
        $member->wife_national_id = $request->wife_national_id;
        $member->wife_commission = $request->wife_commission;
        $member->address = $request->address;

        if ($request->hasFile('document')) {
            $image = $this->fileUpload($request->document, config('location.affiliate.path'), null, null, 'webp', 60, null, null);
            throw_if(empty($image['path']), 'Document could not be uploaded.');
        }

        $member->save();

        $member->salesCenter()->sync($request->sales_center_id);

        DB::commit();
        return back()->with('success', 'Member Updated Successfully');
        /*     } catch (\Exception $e) {
                 return back()->with('error', 'Something went wrong');
             }*/
    }

    public function affiliateMemberEdit($id)
    {
        $admin = $this->user;
        $data['saleCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        $data['singleAffiliateMember'] = AffiliateMember::with('salesCenter', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);
        $data['divisions'] = Division::select('id', 'name')->get();
        return view($this->theme . 'user.affiliate.edit', $data);
    }

    public function affiliateMemberUpdate(Request $request, $id){

        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'sales_center_id' => 'required|exists:sales_centers,id',
            'member_name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'phone' => 'required',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'union_id' => 'nullable|exists:unions,id',
            'member_national_id' => 'nullable',
            'member_commission' => 'nullable',
            'date_of_death' => 'nullable',
            'wife_name' => 'required|string|max:100',
            'wife_national_id' => 'nullable',
            'wife_commission' => 'nullable',
            'document' => 'nullable',
            'address' => 'required',
        ];

        $messages = [
            'sales_center_id.required' => __('Please select sales center'),
            'member_name.required' => __('Member Name is required'),
            'email.email' => __('Invalid email format'),
            'phone.required' => __('Phone number is required'),
            'division_id.exists' => __('Invalid division selected'),
            'district_id.exists' => __('Invalid district selected'),
            'upazila_id.exists' => __('Invalid upazila selected'),
            'union_id.exists' => __('Invalid union selected'),
            'wife_name.required' => __('Member wife name is required'),
            'address.required' => __('Address is required'),
        ];


        $validate = Validator::make($purifiedData, $rules, $messages);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            DB::beginTransaction();
            $member = AffiliateMember::where('company_id', $admin->active_company_id)->findOrFail($id);
            $member->member_name = $request->member_name;
            $member->email = $request->email;
            $member->phone = $request->phone;
            $member->division_id = $request->division_id;
            $member->district_id = $request->district_id;
            $member->upazila_id = $request->upazila_id;
            $member->union_id = $request->union_id;
            $member->member_national_id = $request->member_national_id;
            $member->member_commission = $request->member_commission;
            $member->date_of_death = $request->date_of_death;
            $member->wife_name = $request->wife_name;
            $member->wife_national_id = $request->wife_national_id;
            $member->wife_commission = $request->wife_commission;
            $member->address = $request->address;

            if ($request->hasFile('document')) {
                $image = $this->fileUpload($request->document, config('location.affiliate.path'), null, null, 'webp', 60, null, null);
                throw_if(empty($image['path']), 'Document could not be uploaded.');
            }

            $member->save();

            $member->salesCenter()->sync($request->sales_center_id);

            DB::commit();
            return back()->with('success', 'Member Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function affiliateMemberDetails($id){
        $admin = $this->user;
        $data['memberDetails'] = AffiliateMember::with('salesCenter', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);

        return view($this->theme.'user.affiliate.details', $data);
    }

    public function affiliateMemberDelete(Request $request, $id){
        $admin = $this->user;
        $member = AffiliateMember::where('company_id', $admin->active_company_id)->findOrFail($id);

        $affiliateMemberSalesCenter = AffiliateMemberSalesCenter::where('affiliate_member_id', $id)->get();
        foreach ($affiliateMemberSalesCenter as $salesCenter){
            $salesCenter->delete();
        }

        $member->delete();
        return back()->with('success', 'Affiliate Member Deleted Successfully!');
    }

}
