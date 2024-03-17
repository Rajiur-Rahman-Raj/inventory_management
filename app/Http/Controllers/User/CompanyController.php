<?php

namespace App\Http\Controllers\User;

use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\SalesCenterStoreRequest;
use App\Http\Traits\Notify;
use App\Http\Traits\RawItemPurchaseTrait;
use App\Models\AffiliateMember;
use App\Models\AffiliateMemberSalesCenter;
use App\Models\Badge;
use App\Models\CartItems;
use App\Models\CentralPromoter;
use App\Models\Company;
use App\Http\Traits\Upload;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Expense;
use App\Models\StockMissing;
use App\Models\StockTransferDetails;
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
use Maatwebsite\Excel\Facades\Excel;

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
                    $image = $this->fileUpload($request->logo, config('location.company.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $company->logo = $image['path'];
                        $company->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }


            $company->save();

            if ($request->promoter_check_box) {
                $centralPromoter = new CentralPromoter();
                $centralPromoter->company_id = $company->id;
                $centralPromoter->name = $request->promoter_name;
                $centralPromoter->email = $request->promoter_email;
                $centralPromoter->phone = $request->promoter_phone;
                $centralPromoter->promoter_commission = $request->promoter_commission;
                $centralPromoter->address = $request->promoter_address;
                $centralPromoter->save();
            }

            DB::commit();

            return back()->with('success', 'Company created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function companyEdit($id)
    {
        $user = $this->user;
        $data['singleCompany'] = Company::with('centralPromoter')->where('user_id', $user->id)->findOrFail($id);
        return view($this->theme . 'user.company.edit', $data);
    }

    public function companyUpdate(CompanyUpdateRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            $company = Company::with('centralPromoter')->findOrFail($id);
            $company->name = $request->name;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->trade_id = $request->trade_id;

            if ($request->hasFile('logo')) {
                try {
                    $image = $this->fileUpload($request->logo, config('location.company.path'), null, null, 'avif', null, $company->logo, $company->driver);
                    if ($image) {
                        $company->logo = $image['path'];
                        $company->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }


            $company->save();

            if ($company->centralPromoter) {
                $centralPromoter = CentralPromoter::where('company_id', $company->id)->first();
                $centralPromoter->name = $request->promoter_name;
                $centralPromoter->email = $request->promoter_email;
                $centralPromoter->phone = $request->promoter_phone;
                $centralPromoter->promoter_commission = $request->promoter_commission;
                $centralPromoter->address = $request->promoter_address;
                $centralPromoter->save();
            }

            DB::commit();

            return back()->with('success', 'Company Updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function activeCompany($id)
    {
        $user = $this->user;

        User::with('role')
            ->whereNotNull('role_id')
            ->where('role_id', '!=', 0)
            ->orderBy('role_id', 'asc')
            ->update(['active_company_id' => $id]);

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


        User::with('role')
            ->whereNotNull('role_id')
            ->where('role_id', '!=', 0)
            ->orderBy('role_id', 'asc')
            ->update(['active_company_id' => $id]);

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

//    public function deleteCompany($id)
//    {
//        $user = $this->user;
//        $company = Company::with('salesCenter.user', 'supplier')->where('user_id', $user->id)->findOrFail($id);
//
//        if (count($company->salesCenter) > 0) {
//            foreach ($company->salesCenter as $salesCenter) {
//                if ($salesCenter->user) {
//                    $this->fileDelete($salesCenter->user->driver, $salesCenter->user->image);
//                    $salesCenter->user->delete();
//                }
//                $salesCenter->delete();
//            }
//        }
//
//        if (count($company->supplier) > 0) {
//            foreach ($company->supplier as $supplier) {
//                $this->fileDelete($supplier->driver, $supplier->image);
//                $supplier->delete();
//            }
//        }
//
//        $this->fileDelete($company->driver, $company->logo);
//        $company->delete();
//        return back()->with('success', 'Company Deleted Successfully');
//    }


    public function deleteCompany($id)
    {

        $company = Company::with('salesCenter.user', 'suppliers')->where('user_id', $this->user->id)->findOrFail($id);


        $this->deleteRelatedEntities($company->salesCenter);
        $this->deleteRelatedEntities($company->suppliers);

        $this->fileDelete($company->driver, $company->logo);
        $company->delete();

        return back()->with('success', 'Company Deleted Successfully');
    }

    private function deleteRelatedEntities($entities)
    {
        foreach ($entities as $entity) {
            if (isset($entity->user)) {
                $this->fileDelete($entity->user->driver, $entity->user->image);
                $entity->user->delete();
            } else {
                $this->fileDelete($entity->driver, $entity->image);
                $entity->delete();
            }
        }
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
                    $image = $this->fileUpload($request->image, config('location.user.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $user->image = $image['path'];
                        $user->driver = $image['driver'];
                    }
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
            $salesCenter->discount_percent = $request->discount_percent ?? 0;
            $salesCenter->national_id = $request->national_id;
            $salesCenter->trade_id = $request->trade_id;
            $salesCenter->division_id = $request->division_id;
            $salesCenter->district_id = $request->district_id;
            $salesCenter->upazila_id = $request->upazila_id;
            $salesCenter->union_id = $request->union_id;
            $salesCenter->center_address = $request->center_address;

            $salesCenter->save();
            DB::commit();

            // $this->sendMailSms($user, $type = 'CREATE_SALES_CENTER', [
            //     'center_name' => optional($user->salesCenter)->name,
            //     'owner_name' => $user->name,
            //     'code' => optional($user->salesCenter)->code,
            //     'email' => $user->email,
            //     'password' => $request->password,
            // ]);

            return back()->with('success', 'Sales Center Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function salesCenterEdit($id)
    {
        $admin = $this->user;
        $data['allDivisions'] = Division::where('status', 1)->get();
        $data['salesCenter'] = SalesCenter::with('user', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);
        return view($this->theme . 'user.salesCenter.edit', $data);
    }

    public function updateSalesCenter(Request $request, $id)
    {
        $admin = $this->user;
        DB::beginTransaction();

        $salesCenter = SalesCenter::where('company_id', $admin->active_company_id)->findOrFail($id);

        try {
            $user = User::findOrFail($salesCenter->user_id);
            $user->name = $request->owner_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->address = $request->owner_address;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.user.path'), null, null, 'avif', null, $user->image, $user->driver);
                    if ($image) {
                        $user->image = $image['path'];
                        $user->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Logo could not be uploaded.');
                }
            }

            $user->save();

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

            return back()->with('success', 'Sales Center Updated Successfully');
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
        if ($salesCenter->user) {
            $this->fileDelete(optional($salesCenter->user)->driver, optional($salesCenter->user)->image);
            optional($salesCenter->user)->delete();
        }

        $salesCenter->delete();
        return back()->with('success', 'Sales Center Deleted Successfully!');
    }

    public function employeeList(Request $request)
    {
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_joining_date);
        $toDate = Carbon::parse($request->to_joining_date)->addDay();
        $admin = $this->user;

        $data['employees'] = Employee::where('company_id', $admin->active_company_id)->get();

        $data['employeeLists'] = Employee::
        when(isset($search['employee_id']), function ($query) use ($search) {
            $query->where('id', $search['employee_id']);
        })
            ->when(isset($search['from_joining_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('joining_date', '>=', $fromDate);
            })
            ->when(isset($search['from_joining_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('joining_date', [$fromDate, $toDate]);
            })
            ->where('company_id', $admin->active_company_id)->paginate(config('basic.paginate'));

        return view($this->theme . 'user.employee.index', $data);
    }

    public function createEmployee()
    {
        return view($this->theme . 'user.employee.create');
    }

    public function employeeStore(EmployeeStoreRequest $request)
    {

        $admin = $this->user;
        DB::beginTransaction();
        try {
            $employee = new Employee();
            $employee->company_id = $admin->active_company_id;
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->email = $request->email;
            $employee->national_id = $request->national_id;
            $employee->date_of_birth = Carbon::parse($request->date_of_birth);
            $employee->joining_date = Carbon::parse($request->joining_date);
            $employee->designation = $request->designation;
            $employee->employee_type = $request->employee_type;
            $employee->joining_salary = $request->joining_salary;
            $employee->current_salary = $request->current_salary;
            $employee->present_address = $request->present_address;
            $employee->permanent_address = $request->permanent_address;
            $employee->status = $request->status;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.employee.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $employee->image = $image['path'];
                        $employee->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Photo could not be uploaded.');
                }
            }

            $employee->save();

            DB::commit();

            return back()->with('success', 'Employee Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function employeeDetails($id)
    {
        $admin = $this->user;
        $data['singleEmployee'] = Employee::where('company_id', $admin->active_company_id)->findOrFail($id);
        return view($this->theme . 'user.employee.details', $data);
    }

    public function employeeEdit($id)
    {
        $admin = $this->user;
        $data['singleEmployeeInfo'] = Employee::where('company_id', $admin->active_company_id)->findOrFail($id);
        return view($this->theme . 'user.employee.edit', $data);
    }

    public function employeeUpdate(EmployeeStoreRequest $request, $id)
    {
        $admin = $this->user;
        DB::beginTransaction();
        try {
            $employee = Employee::where('company_id', $admin->active_company_id)->findOrFail($id);
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->email = $request->email;
            $employee->national_id = $request->national_id;
            $employee->date_of_birth = Carbon::parse($request->date_of_birth);
            $employee->joining_date = Carbon::parse($request->joining_date);
            $employee->designation = $request->designation;
            $employee->employee_type = $request->employee_type;
            $employee->joining_salary = $request->joining_salary;
            $employee->current_salary = $request->current_salary;
            $employee->present_address = $request->present_address;
            $employee->permanent_address = $request->permanent_address;
            $employee->status = $request->status;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.employee.path'), null, null, 'avif', null, $employee->image, $employee->driver);
                    if ($image) {
                        $employee->image = $image['path'];
                        $employee->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Photo could not be uploaded.');
                }
            }

            $employee->save();

            DB::commit();

            return back()->with('success', 'Employee Updated Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function employeeDelete($id)
    {
        $admin = $this->user;
        $employee = Employee::where('company_id', $admin->active_company_id)->findOrFail($id);
        $this->fileDelete($employee->driver, $employee->image);
        $employee->delete();
        return back()->with('success', 'Employee Deleted Successfully!');
    }


    public function employeeSalaryList(Request $request)
    {
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $admin = $this->user;

        $data['employees'] = Employee::where('company_id', $admin->active_company_id)->get();

        $data['employeeSalaryLists'] = EmployeeSalary::with('employee')
        ->when(isset($search['employee_id']), function ($query) use ($search) {
            $query->where('employee_id', $search['employee_id']);
        })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('payment_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('payment_date', [$fromDate, $toDate]);
            })
            ->where('company_id', $admin->active_company_id)->paginate(config('basic.paginate'));

        return view($this->theme . 'user.employeeSalary.index', $data);
    }

    public function addEmployeeSalary(Request $request)
    {
        $admin = $this->user;
        DB::beginTransaction();
        try {
            $employeeSalary = new EmployeeSalary();
            $employeeSalary->company_id = $admin->active_company_id;
            $employeeSalary->employee_id = $request->employee_id;
            $employeeSalary->amount = $request->amount;
            $employeeSalary->payment_date = Carbon::parse($request->payment_date);

            $employeeSalary->save();

            DB::commit();

            return back()->with('success', 'Employee Salary Added Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function employeeSalaryEdit(Request $request, $id)
    {
        $admin = $this->user;
        DB::beginTransaction();
        try {
            $employeeSalary = EmployeeSalary::where('company_id', $admin->active_company_id)->findOrFail($id);
            $employeeSalary->employee_id = $request->employee_id;
            $employeeSalary->amount = $request->amount;
            $employeeSalary->payment_date = Carbon::parse($request->payment_date);
            $employeeSalary->save();

            DB::commit();

            return back()->with('success', 'Employee Salary Updated Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function employeeSalaryDelete($id){
        $admin = $this->user;
        $employeeSalary = EmployeeSalary::where('company_id', $admin->active_company_id)->findOrFail($id);
        $employeeSalary->delete();
        return back()->with('success', 'Salary Deleted Successfully!');
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

            DB::beginTransaction();
            $item = new Item();
            $item->name = $request->name;
            $item->unit = $request->unit;
            $item->company_id = optional($loggedInUser->activeCompany)->id;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.item.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $item->image = $image['path'];
                        $item->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
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
                    $image = $this->fileUpload($request->image, config('location.item.path'), null, null, 'avif', null, $item->image, $item->driver);
                    if ($image) {
                        $item->image = $image['path'];
                        $item->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
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
        $this->fileDelete($item->driver, $item->image);
        $item->delete();
        return back()->with('success', 'Item Deleted Successfully!');
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

            $rawItemStock = RawItemPurchaseStock::where('company_id', $admin->active_company_id)->where('raw_item_id', $request->raw_item_id)->select('id', 'quantity', 'cost_per_unit', 'last_cost_per_unit')->first();

            $wastage = new Wastage();
            if ($rawItemStock->quantity > 0) {
                $wastage->company_id = $admin->active_company_id;
                $wastage->raw_item_id = $request->raw_item_id;
                $wastage->quantity = $request->quantity;
                $wastage->cost_per_unit = $rawItemStock->last_cost_per_unit;
                $wastage->total_cost = $request->quantity * $rawItemStock->last_cost_per_unit;
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


    public function stockMissingList(Request $request)
    {
        $search = $request->all();
        $admin = $this->user;
        $data['stockItems'] = Stock::with('item')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->get();
        $data['stockMissingLists'] = StockMissing::with('item')
            ->when(isset($search['item_id']), function ($query) use ($search) {
                $query->where('item_id', $search['item_id']);
            })
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));
        return view($this->theme . 'user.stockMissing.index', $data);
    }

    public function stockMissingStore(Request $request)
    {

        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        try {
            $rules = [
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required',
            ];

            $message = [
                'item_id.required' => __('Item name field is required'),
                'quantity.required' => __('Quantity field is required'),
                'missing_date.required' => __('Missing Date is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $itemStock = Stock::where('company_id', $admin->active_company_id)->where('item_id', $request->item_id)->whereNull('sales_center_id')->select('id', 'quantity', 'cost_per_unit', 'last_cost_per_unit')->first();

            $missingStock = new StockMissing();
            if ($itemStock->quantity > 0) {
                $missingStock->company_id = $admin->active_company_id;
                $missingStock->item_id = $request->item_id;
                $missingStock->quantity = $request->quantity;
                $missingStock->cost_per_unit = $itemStock->last_cost_per_unit;
                $missingStock->total_cost = $request->quantity * $itemStock->last_cost_per_unit;
                $missingStock->missing_date = $request->missing_date;
                $missingStock->save();

                $itemStock->quantity = ($itemStock->quantity <= 0 ? 0 : $itemStock->quantity - $request->quantity);
                $itemStock->save();
            }

            DB::commit();
            return back()->with('success', 'Stock Missing Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function stockMissingDelete(Request $request, $id)
    {
        $admin = $this->user;
        $stockMissing = StockMissing::where('company_id', $admin->active_company_id)->findOrFail($id);
        $stockMissing->delete();
        return back()->with('success', 'Stock Missing Deleted Successfully');
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
                return $q2->whereDate('expense_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('expense_date', [$fromDate, $toDate]);
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
                'expense_date' => 'required',
            ];

            $message = [
                'category_id.required' => __('Category field is required'),
                'amount.required' => __('Amount field is required'),
                'expense_date.required' => __('Expense Date is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();

            Expense::create([
                'company_id' => $admin->active_company_id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'expense_date' => $request->expense_date,
            ]);

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
                'expense_date' => 'required',
            ];

            $message = [
                'category_id.required' => __('Category field is required'),
                'amount.required' => __('Amount field is required'),
                'expense_date.required' => __('Expense Date is required'),
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            DB::beginTransaction();

            $expense = Expense::where('company_id', $admin->active_company_id)->findOrFail($id);
            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->expense_date = $request->expense_date;
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


    public function addStock()
    {
        $admin = $this->user;
        $data['items'] = Item::where('company_id', $admin->active_company_id)->get();
        $data['rawItems'] = RawItem::where('company_id', $admin->active_company_id)->get();
        return view($this->theme . 'user.stock.create', $data);
    }

    public function stockStore(Request $request)
    {
        $admin = $this->user;
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

//        try {
            DB::beginTransaction();
            $stockIn = new StockIn();
            $stockIn->company_id = $admin->active_company_id;
            $stockIn->stock_date = $request->stock_date;
            $stockIn->total_cost = $request->sub_total;
            $stockIn->save();

            $this->storeStockInDetails($request, $stockIn);
            $this->storeStocks($request, $admin);

            DB::commit();
            return back()->with('success', 'Item stock added successfully');

//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', $e->getMessage());
//        }
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
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'stock_date', 'last_stock_date', 'selling_price')
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.stock.index', $data);
    }

    public function stockDetails($item = null, $id = null)
    {
        $data['stock'] = Stock::with('salesCenter:id,name')->select('id', 'sales_center_id', 'item_id', 'last_stock_date')->findOrFail($id);
        $data['singleStockDetails'] = StockInDetails::with('item')->where('item_id', $data['stock']->item_id)->latest()->get();

        $data['totalItemCost'] = $data['singleStockDetails']->sum('total_unit_cost');
        return view($this->theme . 'user.stock.details', $data, compact('item'));
    }

    public function stockTransfer()
    {
        $admin = $this->user;
        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->get();
        $data['stocks'] = Stock::with('item')->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->get();
        return view($this->theme . 'user.stock.transfer', $data);
    }

    public function storeStockTransfer(Request $request)
    {
        $admin = $this->user;
        $companyId = $admin->active_company_id;

        try {
            DB::beginTransaction();

            $stockIn = new StockIn();
            $stockIn->company_id = $admin->active_company_id;
            $stockIn->sales_center_id = $request->sales_center_id;
            $stockIn->stock_date = Carbon::parse($request->transfer_date);
            $stockIn->total_cost = $request->sub_total;
            $stockIn->save();

            foreach ($request->item_id as $key => $item) {
                $salesCenterStock = Stock::firstOrNew([
                    'company_id' => $companyId,
                    'item_id' => $item,
                    'sales_center_id' => $request->sales_center_id,
                ]);

                $salesCenterStock->company_id = $companyId;
                $salesCenterStock->sales_center_id = $request->sales_center_id;
                $salesCenterStock->item_id = $item;
                $salesCenterStock->quantity += (int)$request['item_quantity'][$key];
                $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $request['cost_per_unit'][$key];
                $salesCenterStock->last_cost_per_unit = $request['cost_per_unit'][$key];
                $salesCenterStock->selling_price = $request['cost_per_unit'][$key];
                $salesCenterStock->stock_date = (Carbon::parse($salesCenterStock->last_stock_date)) ?? Carbon::parse($request->transfer_date);
                $salesCenterStock->last_stock_date = Carbon::parse($request->transfer_date);
                $salesCenterStock->save();


                $stockInDetails = new StockInDetails();
                $stockInDetails->stock_in_id = $stockIn->id;
                $stockInDetails->item_id = $item;
                $stockInDetails->quantity = $request['item_quantity'][$key];
                $stockInDetails->cost_per_unit = $request['cost_per_unit'][$key];
                $stockInDetails->total_unit_cost = $request['total_unit_cost'][$key];
                $stockInDetails->stock_date = Carbon::parse($request->transfer_date);
                $stockInDetails->save();


                $stockTransferDetails = new StockTransferDetails();
                $stockTransferDetails->stock_id = $salesCenterStock->id;
                $stockTransferDetails->item_id = $item;
                $stockTransferDetails->quantity = $request['item_quantity'][$key];
                $stockTransferDetails->cost_per_unit = $request['cost_per_unit'][$key];
                $stockTransferDetails->amount = $request['total_unit_cost'][$key];
                $stockTransferDetails->transfer_date = Carbon::parse($request->transfer_date);
                $stockTransferDetails->save();

                $companyStock = Stock::where('company_id', $companyId)->whereNull('sales_center_id')->where('item_id', $item)->first();
                $companyStock->quantity -= (int)$request['item_quantity'][$key];
                $companyStock->save();

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }

        return back()->with('success', 'Stock Successfully Transferred');
    }

    public function stockTransferList(Request $request)
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


        $data['stockLists'] = Stock::with('item:id,name', 'salesCenter:id,name')
            ->when(isset($search['item_id']), function ($query) use ($search) {
                return $query->whereHas('item', function ($q) use ($search) {
                    $q->where('id', $search['item_id']);
                });
            })
            ->when(isset($search['from_date']), function ($q2) use ($fromDate) {
                return $q2->whereDate('last_stock_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($q2) use ($fromDate, $toDate) {
                return $q2->whereBetween('last_stock_date', [$fromDate, $toDate]);
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($q2) use ($admin) {
                $q2->where('company_id', $admin->salesCenter->company_id)
                    ->where('sales_center_id', $admin->salesCenter->id);
            })
            ->where('company_id', $admin->active_company_id)
            ->whereNotNull('sales_center_id')
            ->latest()
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.stock.transferList', $data);
    }


    public function stockTransferDetails($item = null, $id = null)
    {
        $data['stock'] = Stock::with('salesCenter:id,name')->select('id', 'sales_center_id', 'item_id', 'last_stock_date')->findOrFail($id);
        $data['stockTransferDetails'] = StockTransferDetails::with('stocks', 'item')->where('stock_id', $id)->get();
        $data['totalItemCost'] = $data['stockTransferDetails']->sum('amount');

        return view($this->theme . 'user.stock.transferDetails', $data, compact('item'));
    }


    public function salesCenterStockDetails($item = null, $id = null)
    {
        $data['stock'] = Stock::with('salesCenter:id,name')->select('id', 'sales_center_id', 'item_id', 'last_stock_date')->findOrFail($id);
        $data['singleStockDetails'] = StockTransferDetails::with('stocks', 'item')->where('stock_id', $id)->get();
        $data['totalItemCost'] = $data['singleStockDetails']->sum('amount');

        return view($this->theme . 'user.stock.salesCenterStockDetails', $data, compact('item'));
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
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
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

        $admin = $this->user;
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

        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->company_id = ($admin->user_type == 2) ? optional($admin->salesCenter)->company_id : $admin->active_company_id;
            $customer->sales_center_id = ($admin->user_type == 2) ? optional($admin->salesCenter)->id : null;
            $customer->fill($request->only(['name', 'owner_name', 'email', 'phone', 'trade_id', 'national_id', 'check_no', 'branch_name', 'division_id', 'district_id', 'upazila_id', 'union_id', 'address']));

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.customer.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $customer->image = $image['path'];
                        $customer->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            $customer->save();
            DB::commit();

            return back()->with('success', 'Customer Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function customerDetails($id)
    {
        $admin = $this->user;
        $data['customer'] = Customer::with('division', 'district', 'upazila', 'union')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })->findOrFail($id);

        return view($this->theme . "user.customer.details", $data);
    }

    public function customerEdit($id)
    {
        $admin = $this->user;

        $data['customer'] = Customer::with('division', 'district', 'upazila', 'union')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })->findOrFail($id);

        $data['divisions'] = Division::select('id', 'name')->get();
        $data['districts'] = District::select('id', 'name')->get();
        $data['upazilas'] = Upazila::select('id', 'name')->get();
        $data['unions'] = Union::select('id', 'name')->get();
        return view($this->theme . 'user.customer.edit', $data);
    }

    public function customerUpdate(Request $request, $id)
    {
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
            $customer->owner_name = $request->owner_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->trade_id = $request->trade_id;
            $customer->national_id = $request->national_id;
            $customer->check_no = $request->check_no;
            $customer->branch_name = $request->branch_name;
            $customer->division_id = $request->division_id;
            $customer->district_id = $request->district_id;
            $customer->upazila_id = $request->upazila_id;
            $customer->union_id = $request->union_id;
            $customer->address = $request->address;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.customer.path'), null, null, 'avif', null, $customer->image, $customer->driver);
                    if ($image) {
                        $customer->image = $image['path'];
                        $customer->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

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

        $salesFromDate = Carbon::parse($request->sales_from_date);
        $salesToDate = Carbon::parse($request->sales_to_date)->addDay();

        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        $data['salesLists'] = Sale::with('salesCenter')
            ->when(isset($search['invoice_id']), function ($q2) use ($search) {
                return $q2->where('invoice_id', $search['invoice_id']);
            })
            ->when(isset($search['sales_center_id']) && $search['sales_center_id'] != 'all', function ($q) use ($search) {
                $q->whereRaw("sales_center_id REGEXP '[[:<:]]{$search['sales_center_id']}[[:>:]]'");
            })
            ->when(isset($search['sales_from_date']), function ($q2) use ($salesFromDate) {
                return $q2->whereDate('created_at', '>=', $salesFromDate);
            })
            ->when(isset($search['sales_to_date']), function ($q2) use ($salesFromDate, $salesToDate) {
                return $q2->whereBetween('created_at', [$salesFromDate, $salesToDate]);
            })
            ->when(isset($search['status']) && $search['status'] != 'all', function ($q) use ($search) {
                $q->whereRaw("payment_status REGEXP '[[:<:]]{$search['status']}[[:>:]]'");
            })
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id);
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
//                ])->whereNotNull('customer_id');
            })
            ->latest()
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'user.manageSales.salesList', $data);
    }

    public function salesDetails($id)
    {
        $admin = $this->user;
        $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
        $data['singleSalesDetails'] = Sale::with('salesCenter', 'customer', 'salesItems')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($companyId) {
                return $query->where('company_id', $companyId);
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $companyId) {
                return $query->where([
                    ['company_id', $companyId],
                    ['sales_center_id', $admin->salesCenter->id]
                ]);
            })
            ->findOrFail($id);
        return view($this->theme . 'user.manageSales.salesDetails', $data);
    }

    public function salesItem()
    {
        $admin = $this->user;
        $companyId = ($admin->user_type == 1 ? $admin->active_company_id : $admin->salesCenter->company_id);
        $data['items'] = Item::where('company_id', $companyId)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image,driver')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->latest()
            ->get();

        $data['customers'] = Customer::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->latest()
            ->get();


        $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->latest()->get();

        $data['cartItems'] = CartItems::with('item')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->get();

        $data['subTotal'] = $data['cartItems']->sum('cost');

        return view($this->theme . 'user.manageSales.salesItem', $data);
    }

    public function updateItemUnitPrice(Request $request, $id)
    {
        $admin = $this->user;
        $filter_item_id = $request->filter_item_id;
        $stock = Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->select('id', 'selling_price')
            ->findOrFail($id);

        $stock->selling_price = $request->selling_price;
        $stock->save();
        if ($request->filter_by == 'all') {
            return back()->with('success', 'Item Cost Per Unit Update successfully!');
        } else {
            return back()->with('success', 'Item Cost Per Unit Update successfully!')->with('filterItemId', $filter_item_id);
        }

    }

    public function updateSellingPrice(Request $request, $id)
    {
        $admin = $this->user;
        $filter_item_id = $request->filter_item_id;
        $stock = Stock::when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
            return $query->where([
                ['company_id', $admin->salesCenter->company_id],
                ['sales_center_id', $admin->salesCenter->id],
            ]);
        })
            ->select('id', 'selling_price')
            ->findOrFail($id);

        $stock->selling_price = $request->selling_price;
        $stock->save();
        return back()->with('success', 'Item Selling Price Update successfully!')->with('filterItemId', $filter_item_id);
    }

    public function getSelectedItems(Request $request)
    {
        $admin = $this->user;

        $query = Stock::with('item:id,name,image,driver')
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)
                    ->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            });

        if ($request->id !== "all") {
            $query->where('item_id', $request->id);
        }

        $stocks = $query->latest()->get()->map(function ($stock) {
            $item = $stock->item;
            $item->image = getFile(optional($stock->item)->driver, optional($stock->item)->image);
            return $stock;
        });

        return response()->json(['stocks' => $stocks]);
    }

    public function getSelectedCustomer(Request $request)
    {
        $admin = $this->user;

        $customer = Customer::
        when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)
                ->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->select('id', 'name', 'phone', 'address')
            ->findOrFail($request->id);

        return response()->json(['customer' => $customer]);
    }

    public function getSelectedSalesCenter(Request $request)
    {
        $admin = $this->user;
        $salesCenter = SalesCenter::with('user')->where('company_id', $admin->active_company_id)->select('id', 'user_id', 'name', 'center_address', 'code', 'discount_percent')->findOrFail($request->id);
        return response()->json(['salesCenter' => $salesCenter]);
    }

    public function storeCartItems(Request $request)
    {
        $admin = $this->user;
        $stock = $request->data;

        $cartItem = CartItems::where([
            ['company_id', $admin->salesCenter->company_id],
            ['sales_center_id', $admin->salesCenter->id],
        ])
            ->where('stock_id', $stock['id'])
            ->where('item_id', $stock['item_id'])
            ->first();

        if ($cartItem && $cartItem['quantity'] >= $stock['quantity']) {
            $status = false;
            $message = "This item is out of stock";
        } else {
            CartItems::updateOrInsert(
                [
                    'company_id' => $admin->salesCenter->company_id,
                    'sales_center_id' => $admin->salesCenter->id,
                    'stock_id' => $stock['id'],
                    'item_id' => $stock['item_id'],
                ],
                [
                    'quantity' => DB::raw('quantity + 1'),
                    'cost_per_unit' => $stock['selling_price'],
                    'cost' => DB::raw('quantity * cost_per_unit'),
                    'stock_per_unit' => $stock['last_cost_per_unit'],
                    'stock_item_price' => DB::raw('quantity * stock_per_unit'),
                    'created_at' => $cartItem ? $cartItem->created_at : Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            $status = true;
            $message = "Cart item added successfully";
        }

        $cartItems = CartItems::with('item', 'sale')
            ->where([
                ['company_id', $admin->salesCenter->company_id],
                ['sales_center_id', $admin->salesCenter->id],
            ])
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

        $stock = Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->findOrFail($request->stockId);

//        $oldPlusNewQuantity = $request->cartQuantity + $stock->quantity;

        if ($request->cartQuantity && ($request->cartQuantity > $stock->quantity)) {
            $status = false;
            $message = "This item is out of stock";
            $stockQuantity = $stock->quantity;
        } else {
            $cartItem = CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin, $request) {
                return $query->where([
                    'company_id' => $admin->active_company_id,
                    'stock_id' => $request->stockId,
                    'item_id' => $request->itemId,
                ]);
            })
                ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $request) {
                    return $query->where([
                        'company_id' => $admin->salesCenter->company_id,
                        'sales_center_id' => $admin->salesCenter->id,
                        'stock_id' => $request->stockId,
                        'item_id' => $request->itemId,
                    ]);
                })
                ->first();

            if ($cartItem && $request->cartQuantity > $stock->quantity) {
                $status = false;
                $message = "This item is out of stock";
                $stockQuantity = $stock->quantity;
            } else {
                CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin, $request, $stock) {
                    return $query->updateOrInsert(
                        [
                            'company_id' => $admin->active_company_id,
                            'sales_center_id' => null,
                            'stock_id' => $request->stockId,
                            'item_id' => $request->itemId,
                        ],
                        [
                            'cost_per_unit' => $stock->selling_price,
                            'quantity' => $request->cartQuantity,
                            'cost' => DB::raw('quantity * selling_price'),
                            'stock_per_unit' => $stock->last_cost_per_unit,
                            'stock_item_price' => DB::raw('quantity * last_cost_per_unit'),
                            'updated_at' => Carbon::now()
                        ]
                    );
                })
                    ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $request, $stock) {
                        return $query->updateOrInsert(
                            [
                                'company_id' => $admin->salesCenter->company_id,
                                'sales_center_id' => $admin->salesCenter->id,
                                'stock_id' => $request->stockId,
                                'item_id' => $request->itemId,
                            ],
                            [
                                'cost_per_unit' => $stock->selling_price,
                                'quantity' => $request->cartQuantity,
                                'cost' => DB::raw('quantity * selling_price'),
                                'stock_per_unit' => $stock->last_cost_per_unit,
                                'stock_item_price' => DB::raw('quantity * last_cost_per_unit'),
                                'updated_at' => Carbon::now()
                            ]
                        );
                    });

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
        CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })->delete();

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
        CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->findOrFail($request->cartId)
            ->delete();

        $cartItems = CartItems::with('item')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })->get();

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
        $purifiedData = Purify::clean($request->except('_token', '_method'));
        $admin = $this->user;

        DB::beginTransaction();
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

            $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
            $salesCenterId = ($admin->user_type == 1) ? $request->sales_center_id : $admin->salesCenter->id;
            $salesCenter = SalesCenter::where('company_id', $companyId)->select('id', 'code')->findOrFail($salesCenterId);

            $profit = $this->getSalesProfit($request, $admin);

            $sale = new Sale();
            $invoiceId = $salesCenter->code . '-' . mt_rand(1000000, 9999999);
            $due_or_change_amount = (float)floor($request->due_or_change_amount);

            $sale->company_id = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
            $sale->sales_center_id = ($admin->user_type == 1) ? $request->sales_center_id : $admin->salesCenter->id;
            $sale->customer_id = $request->customer_id;
            $sale->sub_total = $request->sub_total;
            $sale->discount_parcent = isset($request->discount_parcent) ? $request->discount_parcent : 0;
            $sale->discount = $request->discount_amount;
            $sale->total_amount = $request->total_amount;
            $sale->customer_paid_amount = $due_or_change_amount <= 0 ? $request->total_amount : $request->customer_paid_amount;
            $sale->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
            $sale->latest_payment_date = Carbon::parse($request->payment_date);
            $sale->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
            $sale->latest_note = $request->note;
            $sale->sales_by = ($admin->user_type == 1) ? 1 : 2;
            $sale->profit = $profit;
            $sale->invoice_id = $invoiceId;

            $items = $this->storeSalesItems($request, $sale);

            $sale->save();
            $this->storeSalesItemsInSalesItemModel($request, $sale);

            $this->storeSalesPayments($request, $sale, $admin);

            $this->storeAndUpdateStocks($request, $sale, $items);

            if ($admin->user_type == 2) {
                $this->giveAffiliateMembersCommission($request, $sale, $admin);
                $this->centralPromoterCommission($request, $sale, $admin);
            }

            CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($companyId) {
                return $query->where('company_id', $companyId)->whereNull('sales_center_id');
            })
                ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $companyId, $salesCenterId) {
                    return $query->where([
                        ['company_id', $companyId],
                        ['sales_center_id', $salesCenterId],
                    ]);
                })
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

        $sale = Sale::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->where('sales_by', 1);
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                    ['sales_by', 2],
                ]);
            })
            ->findOrFail($id);

        $sale->customer_paid_amount = $due_or_change_amount <= 0 ? $sale->total_amount : (float)$request->customer_paid_amount + (float)$sale->customer_paid_amount;
        $sale->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
        $sale->discount += $request->discount_amount;
        $sale->latest_payment_date = Carbon::parse($request->payment_date);
        $sale->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
        $sale->latest_note = $request->note;
        $sale->save();

        $this->storeSalesPayments($request, $sale, $admin);
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
        $RawItemPurchaseIn = RawItemPurchaseIn::where('company_id', $admin->active_company_id)->findOrFail($id);

        $RawItemPurchaseIn->paid_amount = $due_or_change_amount <= 0 ? $RawItemPurchaseIn->total_price : (float)$request->paid_amount + (float)$RawItemPurchaseIn->paid_amount;
        $RawItemPurchaseIn->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
        $RawItemPurchaseIn->last_payment_date = Carbon::parse($request->payment_date);
        $RawItemPurchaseIn->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
        $RawItemPurchaseIn->discount_amount += $request->discount_amount;
        $RawItemPurchaseIn->last_note = $request->note;
        $RawItemPurchaseIn->save();

        $this->storePurchaseRawItemMakePayment($request, $RawItemPurchaseIn, $admin);

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
        $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
        $data['singleSalesDetails'] = Sale::with('company', 'salesCenter.user', 'salesCenter.division', 'salesCenter.district', 'salesCenter.upazila', 'customer', 'customer.division', 'customer.district', 'customer.upazila')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($companyId) {
                return $query->where('company_id', $companyId);
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $companyId) {
                return $query->where([
                    ['company_id', $companyId],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->findOrFail($id);

        return view($this->theme . 'user.manageSales.salesInvoice', $data);
    }

    public function returnSales($id)
    {
        $admin = $this->user;
        // first delete previous cart items when return any product to customers.
        CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->delete();

        // now we need particular sales item for return to customer.
        $data['sale'] = Sale::with('salesCenter.user', 'customer', 'salesItems.sale')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->where('sales_by', 1);
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                    ['sales_by', 2],
                ]);
            })
            ->findOrFail($id);

        // store sales item into cart items table
        foreach ($data['sale']->salesItems as $salesItem) {

            CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin, $salesItem, $id) {
                return $query->updateOrInsert(
                    [
                        'company_id' => $admin->active_company_id,
                        'sales_center_id' => null,
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
            })->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $salesItem, $id) {
                return $query->updateOrInsert(
                    [
                        'company_id' => $admin->salesCenter->company_id,
                        'sales_center_id' => $admin->salesCenter->id,
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
            });


//            CartItems::updateOrInsert(
//                [
//                    'company_id' => $admin->active_company_id,
//                    'stock_id' => $salesItem['stock_id'],
//                    'item_id' => $salesItem['item_id'],
//                ],
//                [
//                    'sales_id' => $id,
//                    'cost_per_unit' => $salesItem['cost_per_unit'],
//                    'quantity' => $salesItem['item_quantity'],
//                    'cost' => $salesItem['item_price'],
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now()
//                ]
//            );

        }

        $data['cartItems'] = CartItems::with('item')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->get();

        $data['subTotal'] = $data['cartItems']->sum('cost');

        $companyId = ($admin->user_type == 1 ? $admin->active_company_id : $admin->salesCenter->company_id);
        $data['items'] = Item::where('company_id', $companyId)
            ->select('id', 'name')
            ->latest()
            ->get();

        $data['stocks'] = Stock::with('item:id,name,image,driver')
            ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->select('id', 'item_id', 'quantity', 'cost_per_unit', 'last_cost_per_unit', 'selling_price')
            ->latest()
            ->get();

        return view($this->theme . 'user.manageSales.returnsalesItem', $data);
    }

    public function returnSalesOrder(Request $request, $id)
    {
        $admin = $this->user;

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        DB::beginTransaction();
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

            $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
            $profit = $this->getSalesProfit($request, $admin);

            $sale = Sale::with('salesItems')
                ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId)->where('sales_by', 1);
                })
                ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $companyId) {
                    return $query->where([
                        ['company_id', $companyId],
                        ['sales_center_id', $admin->salesCenter->id],
                        ['sales_by', 2],
                    ]);
                })->findOrFail($id);


            $due_or_change_amount = (float)floor($request->due_or_change_amount);

            $sale->sub_total = $request->sub_total;
            $sale->discount_parcent = (isset($request->discount_parcent) ? $request->discount_parcent : 0);
            $sale->discount = $request->discount_amount;
            $sale->total_amount = $request->total_amount;
            $sale->customer_paid_amount = $due_or_change_amount >= 0 ? $request->total_amount : ((float)floor($request->previous_paid) + (float)floor($request->customer_paid_amount));
            $sale->due_amount = $due_or_change_amount >= 0 ? 0 : $due_or_change_amount;
            $sale->latest_payment_date = $request->return_date;
            $sale->latest_note = $request->return_note;
            $sale->payment_status = $due_or_change_amount >= 0 ? 1 : 0;
            $sale->profit = $profit;
            $items = $this->storeSalesItems($request, $sale);
            $sale->save();

            $this->updateSalesItems($request, $sale);

            CartItems::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
            })
                ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                    return $query->where([
                        ['company_id', $admin->salesCenter->company_id],
                        ['sales_center_id', $admin->salesCenter->id],
                    ]);
                })
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
        $admin = $this->user;
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
            ->where('company_id', $admin->active_company_id)
            ->latest()
            ->paginate(config('basic.paginate'));

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
            'image' => 'nullable',
            'driver' => 'nullable',
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

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.supplier.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $supplier->image = $image['path'];
                        $supplier->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Photo could not be uploaded.');
                }
            }

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
            'image' => 'nullable',
            'driver' => 'nullable',
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

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.supplier.path'), null, null, 'avif', null, $supplier->image, $supplier->driver);
                    if ($image) {
                        $supplier->image = $image['path'];
                        $supplier->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Photo could not be uploaded.');
                }
            }

            $supplier->save();

            DB::commit();

            return back()->with('success', 'Supplier Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->fileDelete($supplier->driver, $supplier->image);
        $supplier->delete();
        return back()->with('success', "Supplier Deleted Successfully!");
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
                    $image = $this->fileUpload($request->image, config('location.rawItem.path'), null, null, 'avif', null, null, null);
                    if ($image) {
                        $rawItem->image = $image['path'];
                        $rawItem->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
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
            $rawItem = RawItem::findOrFail($id);
            $rawItem->name = $request->name;
            $rawItem->unit = $request->unit;

            if ($request->hasFile('image')) {
                try {
                    $image = $this->fileUpload($request->image, config('location.rawItem.path'), null, null, 'avif', null, $rawItem->image, $rawItem->driver);
                    if ($image) {
                        $rawItem->image = $image['path'];
                        $rawItem->driver = $image['driver'];
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            $rawItem->save();
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
        $this->fileDelete($rawItem->driver, $rawItem->image);
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
            $purchaseIn->discount_percent = $request->discount_percentage ?? 0;
            $purchaseIn->discount_amount = $request->discount_percentage ? (float)$request->sub_total * $request->discount_percentage / 100 : 0;
            $purchaseIn->vat_percent = $request->vat_percentage ?? 0;
            $purchaseIn->vat_amount = $request->vat_percentage ? (float)$request->sub_total * $request->vat_percentage / 100 : 0;
            $purchaseIn->total_price = $request->total_price;
            $purchaseIn->paid_amount = $request->paid_amount;
            $due_or_change_amount = (float)floor($request->due_or_change_amount);
            $purchaseIn->due_amount = $due_or_change_amount <= 0 ? 0 : $request->due_or_change_amount;
            $purchaseIn->last_payment_date = Carbon::parse($request->payment_date);
            $purchaseIn->payment_status = $due_or_change_amount <= 0 ? 1 : 0;
            $purchaseIn->last_note = $request->note;
            $purchaseIn->save();

            $this->storeRawItemPurchaseInDetails($request, $purchaseIn);

            $this->storePurchaseRawItemMakePayment($request, $purchaseIn, $admin);

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


        try {
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

            $member->save();

            $member->salesCenter()->sync($request->sales_center_id);

            DB::commit();
            return back()->with('success', 'Member Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function affiliateMemberEdit($id)
    {
        $admin = $this->user;
        $data['saleCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->where('status', 1)->get();
        $data['singleAffiliateMember'] = AffiliateMember::with('salesCenter', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);
        $data['divisions'] = Division::select('id', 'name')->get();
        return view($this->theme . 'user.affiliate.edit', $data);
    }

    public function affiliateMemberUpdate(Request $request, $id)
    {

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

    public function affiliateMemberDetails($id)
    {
        $admin = $this->user;
        $data['memberDetails'] = AffiliateMember::with('salesCenter', 'division', 'district', 'upazila', 'union')->where('company_id', $admin->active_company_id)->findOrFail($id);

        return view($this->theme . 'user.affiliate.details', $data);
    }

    public function affiliateMemberDelete(Request $request, $id)
    {
        $admin = $this->user;
        $member = AffiliateMember::where('company_id', $admin->active_company_id)->findOrFail($id);

        $affiliateMemberSalesCenter = AffiliateMemberSalesCenter::where('affiliate_member_id', $id)->get();
        foreach ($affiliateMemberSalesCenter as $salesCenter) {
            $salesCenter->delete();
        }

        $member->delete();
        return back()->with('success', 'Affiliate Member Deleted Successfully!');
    }

    public function stockExpenseSalesProfitReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();

        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            if (!empty($search) && $search['from_date'] || $search['to_date']) {
                $reports = Sale::when(isset($search['from_date']), function ($query) use ($fromDate) {
                    return $query->whereDate('created_at', '>=', $fromDate);
                })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                        return $query->where('company_id', $admin->active_company_id)->where('sales_by', 1)
                            ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 THEN total_amount END) AS soldSalesCenterAmount')
                            ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 THEN total_amount END) AS soldCustomerAmount')
                            ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 AND payment_status = 0 THEN due_amount END) AS dueSalesCenterAmount')
                            ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 AND payment_status = 0 THEN due_amount END) AS dueCustomerAmount')
                            ->selectRaw('SUM(profit) AS salesProfit');
                    })
                    ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                        return $query->where([
                            ['company_id', $admin->salesCenter->company_id],
                            ['sales_center_id', $admin->salesCenter->id],
                            ['sales_by', 2],
                        ])->whereNotNull('customer_id')
                            ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 2 AND payment_status = 0 THEN due_amount END) AS dueCustomerAmount');
                    })
                    ->selectRaw('SUM(total_amount) AS totalSalesAmount')
                    ->get()
                    ->toArray();
                $data['reportRecords'] = collect($reports)->collapse();

                if (userType() == 1) {
                    $data['reportRecords']['totalStockAmount'] = StockIn::when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('stock_date', '>=', $fromDate);
                    })
                        ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('stock_date', [$fromDate, $toDate]);
                        })->where('company_id', $admin->active_company_id)->sum('total_cost');
                } else {
                    $data['reportRecords']['totalStockAmount'] = Sale::when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                        ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [$fromDate, $toDate]);
                        })
                        ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                            return $query->where([
                                ['company_id', $admin->salesCenter->company_id],
                                ['sales_center_id', $admin->salesCenter->id],
                                ['sales_by', 1],
                            ])->whereNull('customer_id');
                        })
                        ->sum('total_amount');
                }

                if (userType() == 1) {
                    $data['reportRecords']['affiliateMemberCommission'] = AffiliateMember::when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                        ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [$fromDate, $toDate]);
                        })
                        ->where('company_id', $admin->active_company_id)
                        ->sum('total_commission_amount');

                    $data['reportRecords']['totalExpenseAmount'] = Expense::when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                        ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [$fromDate, $toDate]);
                        })
                        ->where('company_id', $admin->active_company_id)
                        ->sum('amount');
                }

//                dd($data['reportRecords']);
                if (userType() == 1) {
                    $data['reportRecords']['netProfit'] = $data['reportRecords']['salesProfit'] - $data['reportRecords']['totalExpenseAmount'];
                }

                return view($this->theme . 'user.reports.index', $data, compact('search'));
            } else {
                $data['reportRecords'] = null;
                return view($this->theme . 'user.reports.index', $data, compact('search'));
            }


        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.index', $data, compact('search'));
        }
    }

    public function exportStockExpenseSalesProfitReports(Request $request)
    {
//        return Excel::download(new SalesReportExport($request), 'sales_report.xlsx');
    }

}
