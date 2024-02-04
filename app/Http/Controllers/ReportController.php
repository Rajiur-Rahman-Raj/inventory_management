<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseReportExport;
use App\Exports\PurchaseExport;
use App\Exports\StockReportExport;
use App\Exports\wastageReportExport;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Item;
use App\Models\RawItem;
use App\Models\RawItemPurchaseIn;
use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\Wastage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function purchaseReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {

                $data['purchaseReportRecords'] = RawItemPurchaseIn::with('supplier:id,name', 'rawItemDetails.rawItem')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('purchase_date', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('purchase_date', [$fromDate, $toDate]);
                    })
                    ->when(isset($search['supplier_id']), function ($query) use ($search) {
                        return $query->where('supplier_id', $search['supplier_id']);
                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();


                $data['totalPrice'] = $data['purchaseReportRecords']->flatMap->rawItemDetails->sum('total_unit_cost');

                return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
            } else {
                $data['purchaseReportRecords'] = null;
                return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
        }
    }

    public function exportPurchaseReports(Request $request)
    {
        $admin = $this->user;
       return Excel::download(new PurchaseExport($request, $admin), 'purchaseReport.xlsx');
    }


    public function stockReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);

        try {
            $data['items'] = Item::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {

                $data['stockReportRecords'] = StockIn::with('stockInDetails.item')
                    ->when(isset($search['from_date']), fn($query) => $query->whereDate('stock_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('stock_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalStockCost'] = $data['stockReportRecords']->flatMap->stockInDetails->sum('total_unit_cost');

                return view($this->theme . 'user.reports.stock.index', $data, compact('search'));

            } else {
                $data['stockReportRecords'] = null;
                return view($this->theme . 'user.reports.stock.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.stock.index', $data, compact('search'));
        }
    }

    public function exportStockReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new StockReportExport($request, $admin), 'stockReport.xlsx');
    }


    public function wastageReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {

            $data['rawItems'] = RawItem::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {

                $data['wastageReportRecords'] = Wastage::with('rawItem:id,name')
                    ->when(isset($search['from_date']), fn($query) => $query->whereDate('wastage_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('wastage_date', [$fromDate, $toDate]))
                    ->when($search['raw_item_id'] != null, fn($query) => $query->where('raw_item_id', $search['raw_item_id']))
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalWastage'] = $data['wastageReportRecords']->sum('quantity');

                return view($this->theme . 'user.reports.wastage.index', $data, compact('search'));

            } else {
                $data['wastageReportRecords'] = null;
                return view($this->theme . 'user.reports.wastage.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {

            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.wastage.index', $data, compact('search'));
        }
    }

    public function exportWastageReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new wastageReportExport($request, $admin), 'wastageReport.xlsx');
    }



    public function expenseReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {

            $data['expenseCategories'] = ExpenseCategory::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {
                $data['expenseReportRecords'] = Expense::with('expenseCategory:id,name')
                    ->when(isset($search['from_date']), fn($query) => $query->whereDate('expense_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('expense_date', [$fromDate, $toDate]))
                    ->when($search['expense_category_id'] != null, fn($query) => $query->where('category_id', $search['expense_category_id']))
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalExpense'] = $data['expenseReportRecords']->sum('amount');

                return view($this->theme . 'user.reports.expense.index', $data, compact('search'));

            } else {
                $data['expenseReportRecords'] = null;
                return view($this->theme . 'user.reports.expense.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {

            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.expense.index', $data, compact('search'));
        }
    }

    public function exportExpenseReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new ExpenseReportExport($request, $admin), 'expenseReport.xlsx');
    }


    // working here....
    public function purchasePaymentReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {

                $data['purchaseReportRecords'] = RawItemPurchaseIn::with('supplier:id,name', 'rawItemDetails.rawItem')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('purchase_date', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('purchase_date', [$fromDate, $toDate]);
                    })
                    ->when(isset($search['supplier_id']), function ($query) use ($search) {
                        return $query->where('supplier_id', $search['supplier_id']);
                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();


                $data['totalPrice'] = $data['purchaseReportRecords']->flatMap->rawItemDetails->sum('total_unit_cost');

                return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
            } else {
                $data['purchaseReportRecords'] = null;
                return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
        }
    }

    public function exportPurchasePaymentReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new PurchaseExport($request, $admin), 'purchaseReport.xlsx');
    }

}
