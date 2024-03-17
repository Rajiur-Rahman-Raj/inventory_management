<?php

namespace App\Exports;

use App\Models\StockIn;
use App\Models\StockMissing;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockMissingReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $stockMissingReportRecords = StockMissing::with('item:id,name')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('missing_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('missing_date', [$fromDate, $toDate]))
            ->when($search['item_id'] != null, fn($query) => $query->where('item_id', $search['item_id']))
            ->where('company_id', $admin->active_company_id)
            ->get();

        $totalMissingStock = $stockMissingReportRecords->sum('quantity');
        $totalMissingAmount = $stockMissingReportRecords->sum('total_cost');

        $missingStockReportData = $stockMissingReportRecords->map(function ($missingStock) use (&$SL) {
            return [
                'SL' => ++$SL,
                'Item' => $missingStock->item->name,
                'Quantity' => $missingStock->quantity,
                'Cost Per Unit' => $missingStock->cost_per_unit,
                'Sub Total' => $missingStock->total_cost,
                'Date Of Missing' => customDate($missingStock->missing_date)
            ];
        });

        $missingStockReportData->push([
            'Sl' => '',
            'Total Missing Quantity' => 'Total Missing Quantity',
            'quantity' => $totalMissingStock,
            'Total Missing Amount' => 'Total Missing Amount',
            'Total Amount' => $totalMissingAmount,
        ]);

        return $missingStockReportData;
    }

    public function headings(): array
    {

        $data = [
            'SL.',
            'Item',
            'Quantity',
            'Cost Per Unit',
            'Sub Total',
            'Date Of Missing',
        ];

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);

                // Styling Total Commission row
                $totalCommissionRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getDelegate()->getStyle('B'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C'.$totalCommissionRow)->getFont()->setBold(true);

                $event->sheet->getDelegate()->getStyle('D'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('E'.$totalCommissionRow)->getFont()->setBold(true);
            },
        ];
    }
}
