<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesPaymentReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $currencyText = config('basic.currency_text');
        $currencySymbol = config('basic.currency_symbol');

        $salesPaymentReportRecords = Sale::with('salesCenter:id,name', 'customer:id,name', 'salesPayments')
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
            ->where('sales_by', 1)
            ->get();

        $totalPaidAmount = $salesPaymentReportRecords->flatMap->salesPayments->sum('amount');
        $totalDueAmount = $salesPaymentReportRecords->flatMap->salesPayments->sum('due');

        $salesPaymentReportData = $salesPaymentReportRecords->flatMap(function ($sale) use (&$SL) {
            return $sale->salesPayments->map(function ($saleDetails) use (&$SL, $sale) {
                return [
                    'SL' => ++$SL,
                    'Sales Center' => $sale->salesCenter->name,
                    'Paid Amount' => config('basic.currency_symbol').' '.$saleDetails->amount,
                    'Due Amount' => config('basic.currency_symbol').' '.$saleDetails->due,
                    'Payment Date' => customDate($saleDetails->payment_date),
                ];
            });
        });

        $salesPaymentReportData->push([
            'Sl' => '',
            'Total Paid' => 'Total',
            'Paid Amount' => $totalPaidAmount.' '.$currencyText,
            'Due Amount' => $totalDueAmount.' '.$currencyText,
        ]);

        return $salesPaymentReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Sales Center',
            'Paid Amount',
            'Due Amount',
            'Payment Date',
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
                $event->sheet->getDelegate()->getStyle('B'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C'.$totalCommissionRow)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('D'.$totalCommissionRow)->getFont()->setBold(true);
            },
        ];
    }
}
