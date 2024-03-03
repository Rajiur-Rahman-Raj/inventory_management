<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $salesReportRecords = Sale::with('salesCenter:id,name', 'customer:id,name', 'salesItems.item')
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

        $totalSales = $salesReportRecords->flatMap->salesItems->sum('item_price');

        $salesReportData = $salesReportRecords->flatMap(function ($sale, $currencySymbol) use (&$SL) {
            return $sale->salesItems->map(function ($saleDetails) use (&$SL, $sale, $currencySymbol) {
                return [
                    'SL' => ++$SL,
                    'Sales Center' => $sale->salesCenter->name,
                    'Item' => $saleDetails->item->name,
                    'Quantity' => $saleDetails->item_quantity,
                    'Cost Per Unit' => $saleDetails->cost_per_unit,
                    'Sales Date' => customDate($saleDetails->created_at),
                    'Sub Total' => config('basic.currency_symbol').' '.$saleDetails->item_price,
                ];
            });
        });

        $salesReportData->push([
            'Sl' => '',
            'Sales Center' => '',
            'Item' => '',
            'Quantity' => '',
            'Cost Per Unit' => '',
            'Total Sales' => 'Total',
            'Amount' => $totalSales.' '.config('basic.currency_text'),
        ]);
        return $salesReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Sales Center',
            'Item',
            'Quantity',
            'Cost Per Unit',
            'Sales Date',
            'Sub Total',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);

                // Styling Total Commission row
                $totalCommissionRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getDelegate()->getStyle('F'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('G'.$totalCommissionRow)->getFont()->setBold(true);

                $event->sheet->getDelegate()->getStyle('F'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('G'.$totalCommissionRow)->getFont()->setBold(true);
            },
        ];
    }
}
