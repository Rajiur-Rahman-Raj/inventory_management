<?php

namespace App\Exports;

use App\Models\AffiliateMemberCommission;
use App\Models\CentralPromoter;
use App\Models\CentralPromoterCommission;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AffiliateReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $centralPromoter = CentralPromoter::where('company_id', $admin->active_company_id)->select('id', 'name')->get();

        $affiliateReportRecords = AffiliateMemberCommission::with('affiliateMember:id,member_name')
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

        $centralPromoterReportRecords = CentralPromoterCommission::with('centralPromoter:id,name')->where('central_promoter_id', $centralPromoter[0]->id)
            ->when(isset($search['from_date']), function ($query) use ($fromDate) {
                return $query->whereDate('commission_date', '>=', $fromDate);
            })
            ->when(isset($search['to_date']), function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('commission_date', [$fromDate, $toDate]);
            })
            ->when(isset($search['central_promoter_id']) && $search['central_promoter_id'] != null, function ($query) use ($search) {
                return $query->where('central_promoter_id', $search['central_promoter_id']);
            })
            ->first();

        $affiliateReportRecords->prepend($centralPromoterReportRecords);

        $totalCommission = $affiliateReportRecords->sum('amount');

        $affiliateReportData = $affiliateReportRecords->map(function ($commission) use (&$SL, $currencySymbol) {
            return [
                'SL' => ++$SL,
                'Affiliator' => $SL == 1 ? $commission->centralPromoter->name : $commission->affiliateMember->member_name,
                'Commission' => $currencySymbol.' '.$commission->amount,
                'Date Of Commission' => $commission->commission_date,
            ];
        });


        $affiliateReportData->push([
            'Sl' => '',
            'Total Commission' => 'Total Commission',
            'Commission Amount' => $totalCommission.' '.$currencyText,
        ]);

        return $affiliateReportData;
    }


    public function headings(): array
    {
        return [
            'SL',
            'Affiliator',
            'Commission',
            'Date Of Commission',
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
            },
        ];
    }
}
