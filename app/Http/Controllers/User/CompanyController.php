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
use App\Models\Division;
use App\Models\Item;
use App\Models\SalesCenter;
use App\Models\Stock;
use App\Models\StockIn;
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

        if (count($company->salesCenter) > 0){
            foreach ($company->salesCenter as $salesCenter){
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

    public function salesCenterDetails($id){
        $data['salesCenter'] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union')->findOrFail($id);
        return view($this->theme. 'user.salesCenter.details', $data);
    }

    public function deleteSalesCenter($id){
        $salesCenter = SalesCenter::with('user')->findOrFail($id);
        optional($salesCenter->user)->delete();
        $salesCenter->delete();

        return back()->with('success', 'Sales Center Deleted Successfully!');

    }

    public function salesCenterEdit($id){
        $data['singleSalesCenter '] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union')->findOrFail($id);
        return view($this->theme.'user.salesCenter.edit', $data);
    }

    public function itemList(Request $request){
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
        return view($this->theme.'user.items.index', $data);
    }

    public function itemStore(Request $request){
        $loggedInUser = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        if ($request->name == null){
            return back()->with('error', 'Item name is required');
        }

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
        $item->save();
        return back()->with('success', 'Item Created Successfully');
    }

    public function updateItem(Request $request, $id){
        $item = Item::findOrFail($id);

        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->save();

        return back()->with('success', 'Item Update Successfully');
    }

    public function deleteItem($id){
        $item = Item::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Item Deleted Successfully!');
    }

    public function stockList(){
        $data['stockLists'] = Stock::latest()->paginate(config('basic.paginate'));
        return view($this->theme.'user.stock.index', $data);
    }

    public function addStock(){
        $loggedInUser = $this->user;
        $data['allItems'] = Item::where('company_id', optional($loggedInUser->activeCompany)->id)->get();
        return view($this->theme.'user.stock.create', $data);
    }

    public function stockStore(Request $request){

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

    public function stockDetails($id){
        $data['singleStock'] = Stock::findOrFail($id);
        return view($this->theme.'user.stock.details', $data);
    }

    public function getSelectedItemUnit(Request $request) {
        $unit = DB::table('items')
                ->where('id', $request->itemId)
                ->value('unit');

        return response()->json(['unit' => $unit]);
    }

}
