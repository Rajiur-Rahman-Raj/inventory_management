<?php

namespace App\Http\Controllers;

use App\Models\RawItemPurchaseIn;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

                $totalPrice = 0;
                foreach ($data['purchaseReportRecords'] as $rawItem) {
                    $totalPrice += $rawItem->rawItemDetails->sum('total_unit_cost');
                }

                return view($this->theme . 'user.reports.purchase.index', $data, compact('search', 'totalPrice'));
            } else {
                $data['purchaseReportRecords'] = null;
                return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
            }

        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            return view($this->theme . 'user.reports.purchase.index', $data, compact('search'));
        }
    }

    public function exportPurchaseReport(Request $request)
    {
        dd('export purchase report here');
    }
}
