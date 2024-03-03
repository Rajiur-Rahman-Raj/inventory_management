<?php

namespace App\Exports;

use App\Models\RawItemPurchaseIn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchasePaymentReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $purchasePaymentReportRecords = RawItemPurchaseIn::with('supplier:id,name', 'purchasePayments')
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

        $totalPaidAmount = $purchasePaymentReportRecords->flatMap->purchasePayments->sum('amount');
        $totalDueAmount = $purchasePaymentReportRecords->sum('due_amount');

        $purchasePaymentReportData = $purchasePaymentReportRecords->flatMap(function ($purchaseIn) use (&$SL, $currencySymbol, $currencyText) {
            return $purchaseIn->purchasePayments->map(function ($purchasePayment) use (&$SL, $currencySymbol, $currencyText,$purchaseIn) {
                return [
                    'SL' => ++$SL,
                    'supplier' => $purchaseIn->supplier->name,
                    'Paid Amount' => $currencySymbol.' '.$purchasePayment->amount,
                    'Payment Date' => customDate($purchasePayment->payment_date),
                    'Due Amount' => $currencySymbol.' '.$purchasePayment->due,
                ];
            });
        });

        $purchasePaymentReportData->push([
            'Sl' => '',
            'Total Paid' => 'Total Paid',
            'Paid Amount' => $totalPaidAmount.' '.$currencyText,
            'Total Due' => 'Total Due',
            'Due Amount' => $totalDueAmount.' '.$currencySymbol,
        ]);

        return $purchasePaymentReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'supplier',
            'Paid Amount',
            'Payment Date',
            'Due Amount',
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
                $event->sheet->getDelegate()->getStyle('E'.$totalCommissionRow)->getFont()->setBold(true);
            },
        ];
    }
}
