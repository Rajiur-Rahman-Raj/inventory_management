<?php

namespace App\Exports;

use App\Models\RawItemPurchaseIn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchaseExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
//class PurchaseExport implements FromCollection
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

        $purchaseReportRecords = RawItemPurchaseIn::with('supplier:id,name', 'rawItemDetails.rawItem')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('purchase_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('purchase_date', [$fromDate, $toDate]))
            ->when($search['supplier_id'] != null, fn($query) => $query->where('supplier_id', $search['supplier_id']))
            ->where('company_id', $admin->active_company_id)
            ->get();

        $totalPrice = $purchaseReportRecords->flatMap->rawItemDetails->sum('total_unit_cost');

        $purchaseReportData = $purchaseReportRecords->flatMap(function ($purchaseIn) use (&$SL) {
            return $purchaseIn->rawItemDetails->map(function ($purchaseInDetails) use (&$SL, $purchaseIn) {
                return [
                    'SL' => ++$SL,
                    'supplier' => $purchaseIn->supplier->name,
                    'Raw Item' => $purchaseInDetails->rawItem->name,
                    'Quantity' => $purchaseInDetails->quantity,
                    'Cost Per Unit' => $purchaseInDetails->cost_per_unit,
                    'Purchase Date' => customDate($purchaseInDetails->purchase_date),
                    'Sub Total' => $purchaseInDetails->total_unit_cost,
                ];
            });
        });


        $purchaseReportData->push([
            'Sl' => '',
            'Supplier' => '',
            'Raw Item' => '',
            'Quantity' => '',
            'Cost Per Unit' => '',
            'Total Price' => 'Total',
            'Amount' => $totalPrice,
        ]);

        return $purchaseReportData;
    }


    public function headings(): array
    {
        return [
            'SL',
            'Supplier',
            'Raw Item',
            'Quantity',
            'Cost Per Unit',
            'Purchase Date',
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
