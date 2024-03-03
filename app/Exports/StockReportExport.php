<?php

namespace App\Exports;

use App\Models\StockIn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StockReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $SL = 0;

        $stockReportRecords = StockIn::with('stockInDetails.item')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('stock_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('stock_date', [$fromDate, $toDate]))
            ->where('company_id', $admin->active_company_id)
            ->whereNull('sales_center_id')
            ->get();

        $totalStockCost = $stockReportRecords->flatMap->stockInDetails->sum('total_unit_cost');

        $stockReportData = $stockReportRecords->flatMap(function ($stockIn) use (&$SL) {
            return $stockIn->stockInDetails->map(function ($stockInDetail) use (&$SL, $stockIn) {
                return [
                    'SL' => ++$SL,
                    'Item' => $stockInDetail->item->name,
                    'Quantity' => $stockInDetail->quantity,
                    'Cost Per Unit' => $stockInDetail->cost_per_unit,
                    'Stock Date' => customDate($stockInDetail->stock_date),
                    'Sub Total' => $stockInDetail->total_unit_cost,
                ];
            });
        });

        $stockReportData->push([
            'Sl' => '',
            'Item' => '',
            'Quantity' => '',
            'Cost Per Unit' => '',
            'Total Cost' => 'Total Cost',
            'Amount' => $totalStockCost,
        ]);

        return $stockReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Item',
            'Quantity',
            'Cost Per Unit',
            'Stock Date',
            'Sub Total',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);
            },
        ];
    }
}
