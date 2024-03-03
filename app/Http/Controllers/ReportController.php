<?php

namespace App\Http\Controllers;

use App\Exports\AffiliateReportExport;
use App\Exports\ExpenseReportExport;
use App\Exports\ProfitLossReport;
use App\Exports\PurchaseExport;
use App\Exports\PurchasePaymentReportExport;
use App\Exports\SalesPaymentReportExport;
use App\Exports\SalesReportExport;
use App\Exports\StockReportExport;
use App\Exports\wastageReportExport;
use App\Models\AffiliateMember;
use App\Models\AffiliateMemberCommission;
use App\Models\CentralPromoter;
use App\Models\CentralPromoterCommission;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Item;
use App\Models\RawItem;
use App\Models\RawItemPurchaseIn;
use App\Models\Sale;
use App\Models\SalesCenter;
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
                    ->when($search['supplier_id'] != null, function ($query) use ($search) {
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
                    ->whereNull('sales_center_id')
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
                $data['totalWastageAmount'] = $data['wastageReportRecords']->sum('total_cost');

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

    public function purchasePaymentReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            $data['suppliers'] = Supplier::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {

                $data['purchasePaymentReportRecords'] = RawItemPurchaseIn::with('supplier:id,name', 'purchasePayments')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('purchase_date', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('purchase_date', [$fromDate, $toDate]);
                    })
                    ->when($search['supplier_id'] != null, function ($query) use ($search) {
                        return $query->where('supplier_id', $search['supplier_id']);
                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalPaidAmount'] = $data['purchasePaymentReportRecords']->flatMap->purchasePayments->sum('amount');
                $data['totalDueAmount'] = $data['purchasePaymentReportRecords']->sum('due_amount');

                return view($this->theme . 'user.reports.purchase.payment', $data, compact('search'));
            } else {
                $data['purchasePaymentReportRecords'] = null;
                return view($this->theme . 'user.reports.purchase.payment', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.purchase.payment', $data, compact('search'));
        }
    }

    public function exportPurchasePaymentReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new PurchasePaymentReportExport($request, $admin), 'purchasePaymentReport.xlsx');
    }


    public function affiliateReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {

            $data['affiliateMembers'] = AffiliateMember::where('company_id', $admin->active_company_id)->select('id', 'member_name')->get();
            $data['centralPromoter'] = CentralPromoter::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {
                $data['affiliateReportRecords'] = AffiliateMemberCommission::with('affiliateMember:id,member_name')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('commission_date', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('commission_date', [$fromDate, $toDate]);
                    })
                    ->when($search['affiliate_member_id'] != null, function ($query) use ($search) {
                        return $query->where('affiliate_member_id', $search['affiliate_member_id']);
                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();

//                $data['centralPromoterReportRecords'] = CentralPromoterCommission::where('central_promoter_id', $data['centralPromoter'][0]->id)
//                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
//                        return $query->whereDate('commission_date', '>=', $fromDate);
//                    })
//                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
//                        return $query->whereBetween('commission_date', [$fromDate, $toDate]);
//                    })
//                    ->when($search['central_promoter_id'] != null, function ($query) use ($search) {
//                        return $query->where('central_promoter_id', $search['central_promoter_id']);
//                    })
//                    ->where('company_id', $admin->active_company_id)
//                    ->get();



                $data['totalCommission'] = $data['affiliateReportRecords']->sum('amount');

                return view($this->theme . 'user.reports.affiliate.index', $data, compact('search'));
            } else {
                $data['affiliateReportRecords'] = null;
                return view($this->theme . 'user.reports.affiliate.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.affiliate.index', $data, compact('search'));
        }
    }

    public function exportAffiliateReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new AffiliateReportExport($request, $admin), 'affiliateReport.xlsx');
    }

    //working here
    public function salesReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->select('id', 'name')->get();
            $data['customers'] = Customer::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {
                $data['salesReportRecords'] = Sale::with('salesCenter:id,name', 'customer:id,name', 'salesItems.item')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->when($search['sales_center_id'] != null, function ($query) use ($search) {
                        return $query->where('sales_center_id', $search['sales_center_id']);
                    })
//                    ->when($search['customer_id'] != null, function ($query) use ($search) {
//                        return $query->where('customer_id', $search['customer_id']);
//                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalSales'] = $data['salesReportRecords']->flatMap->salesItems->sum('item_price');

                return view($this->theme . 'user.reports.sales.index', $data, compact('search'));

            } else {
                $data['salesReportRecords'] = null;
                return view($this->theme . 'user.reports.sales.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.sales.index', $data, compact('search'));
        }
    }

    public function exportSalesReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new SalesReportExport($request, $admin), 'salesReport.xlsx');
    }

    //working here
    public function salesPaymentReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            $data['salesCenters'] = SalesCenter::where('company_id', $admin->active_company_id)->select('id', 'name')->get();
            $data['customers'] = Customer::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

            if (!empty($search)) {
                $data['salesPaymentReportRecords'] = Sale::with('salesCenter:id,name', 'customer:id,name', 'salesPayments')
                    ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->when($search['sales_center_id'] != null, function ($query) use ($search) {
                        return $query->where('sales_center_id', $search['sales_center_id']);
                    })
//                    ->when($search['customer_id'] != null, function ($query) use ($search) {
//                        return $query->where('customer_id', $search['customer_id']);
//                    })
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $data['totalPaidAmount'] = $data['salesPaymentReportRecords']->flatMap->salesPayments->sum('amount');
                $data['totalDueAmount'] = $data['salesPaymentReportRecords']->sum('due_amount');

                return view($this->theme . 'user.reports.sales.payment', $data, compact('search'));
            } else {
                $data['salesPaymentReportRecords'] = null;
                return view($this->theme . 'user.reports.sales.payment', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.sales.payment', $data, compact('search'));
        }
    }

    public function exportSalesPaymentReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new SalesPaymentReportExport($request, $admin), 'salesPaymentReportExport.xlsx');
    }

    public function profitLossReports(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date)->addDay();

        try {
            if (!empty($search)) {
                $profitLossReports = Sale::when(isset($search['from_date']), function ($query) use ($fromDate) {
                    return $query->whereDate('created_at', '>=', $fromDate);
                })
                    ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->where('company_id', $admin->active_company_id)
                    ->selectRaw('SUM(total_amount) AS totalSales')
                    ->selectRaw('SUM(due_amount) AS totalSalesDue')
                    ->get()
                    ->toArray();

                $data['profitLossReportRecords'] = collect($profitLossReports)->collapse();

                $sales = Sale::with('salesItems')->
                    when(isset($search['from_date']), function ($query) use ($fromDate) {
                        return $query->whereDate('created_at', '>=', $fromDate);
                    })
                        ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [$fromDate, $toDate]);
                        })
                    ->where('company_id', $admin->active_company_id)
                    ->get();

                $salesStockPrice = $sales->flatMap->salesItems->sum('stock_item_price');

                $data['profitLossReportRecords']['totalStockCost'] = $salesStockPrice;

                $data['profitLossReportRecords']['revenue'] = $data['profitLossReportRecords']['totalSales'] - $data['profitLossReportRecords']['totalStockCost'];


                $data['purchase'] = RawItemPurchaseIn::when(isset($search['from_date']), fn($query) => $query->whereDate('purchase_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('purchase_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)->get();

                $data['profitLossReportRecords']['totalPurchase'] = $data['purchase']->sum('total_price');
                $data['profitLossReportRecords']['totalPurchaseDue'] = $data['purchase']->sum('due_amount');

                $data['profitLossReportRecords']['totalStocks'] = StockIn::when(isset($search['from_date']), fn($query) => $query->whereDate('stock_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('stock_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)->sum('total_cost');

                $data['profitLossReportRecords']['totalWastage'] = Wastage::when(isset($search['from_date']), fn($query) => $query->whereDate('wastage_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('wastage_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)->sum('total_cost');

                $data['profitLossReportRecords']['totalAffiliateCommission'] = AffiliateMemberCommission::when(isset($search['from_date']), fn($query) => $query->whereDate('commission_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('commission_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)->sum('amount');


                $data['profitLossReportRecords']['totalExpense'] = Expense::when(isset($search['from_date']), fn($query) => $query->whereDate('expense_date', '>=', $fromDate))
                    ->when(isset($search['to_date']), fn($query) => $query->whereBetween('expense_date', [$fromDate, $toDate]))
                    ->where('company_id', $admin->active_company_id)->sum('amount');

                $data['profitLossReportRecords']['netProfit'] = $data['profitLossReportRecords']['revenue'] - $data['profitLossReportRecords']['totalAffiliateCommission'] - $data['profitLossReportRecords']['totalExpense'];


                return view($this->theme . 'user.reports.profitLoss.index', $data, compact('search'));
            } else {
                $data['profitLossReportRecords'] = null;
                return view($this->theme . 'user.reports.index', $data, compact('search'));
            }


        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.index', $data, compact('search'));
        }
    }

    public function exportProfitLossReports(Request $request)
    {
        $admin = $this->user;
        return Excel::download(new ProfitLossReport($request, $admin), 'profitLossReport.xlsx');
    }


}
