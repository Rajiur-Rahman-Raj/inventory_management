<?php

namespace App\Exports;

use App\Models\AffiliateMemberCommission;
use App\Models\Expense;
use App\Models\RawItemPurchaseIn;
use App\Models\Sale;
use App\Models\StockIn;
use App\Models\Wastage;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

//use Maatwebsite\Excel\Events\AfterSheet;

class ProfitLossReport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $request;
    private $user;

    public function __construct($request, $admin)
    {
        $this->request = $request;
        $this->user = $admin;
    }

    public function collection()
    {
        $admin = $this->user;
        $fromDate = Carbon::parse($this->request->from_date);
        $toDate = Carbon::parse($this->request->to_date)->addDay();
        $search = $this->request;

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

        $myData = [];
        // Prepare data in a structured format
        $myData[] = ['Total Purchase', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalPurchase']];
        $myData[] = ['Total Stock', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalStocks']];
        $myData[] = ['Total Sales', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalSales']];
        $myData[] = ['Total Wastage', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalWastage']];
        $myData[] = ['Total Affiliate Commission', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalAffiliateCommission']];
        $myData[] = ['Total Expense', config('basic.currency_text').' '.$data['profitLossReportRecords']['totalExpense']];
        $myData[] = ['Revenue', config('basic.currency_text').' '.$data['profitLossReportRecords']['revenue']];
        $myData[] = ['Net Profit', config('basic.currency_text').' '.$data['profitLossReportRecords']['netProfit']];


        return collect($myData);
    }

    public function headings(): array
    {

       $data = [
           'Reports Summery',
           'Total Amount',
       ];

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:B' . ($event->sheet->getDelegate()->getHighestRow()); // Assuming your data starts from A1 and spans to column B
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // Set the background color for the headings
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF00', // Yellow color
                        ],
                    ],
                ]);
            },
        ];
    }

}
