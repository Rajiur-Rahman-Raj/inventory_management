<?php

namespace App\Exports;

use App\Models\Wastage;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class wastageReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $wastageReportRecords = Wastage::with('rawItem:id,name')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('wastage_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('wastage_date', [$fromDate, $toDate]))
            ->when($search['raw_item_id'] != null, fn($query) => $query->where('raw_item_id', $search['raw_item_id']))
            ->where('company_id', $admin->active_company_id)
            ->get();

        $totalWastage = $wastageReportRecords->sum('quantity');

        $wastageReportData = $wastageReportRecords->map(function ($wastage) use (&$SL) {
            return [
                'SL' => ++$SL,
                'Raw Item' => $wastage->rawItem->name,
                'Quantity' => $wastage->quantity,
                'Date Of Wastage' => customDate($wastage->wastage_date)
            ];
        });

        $wastageReportData->push([
            'Sl' => '',
            'Total Wastage' => 'Total Wastage',
            'quantity' => $totalWastage,
        ]);

        return $wastageReportData;
    }



    public function headings(): array
    {
        return [
            'SL',
            'Raw Item',
            'Quantity',
            'Date Of Wastage',
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
