<?php

namespace App\Exports;

use App\Models\EmployeeSalary;
use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SalaryReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $salaryReportRecords = EmployeeSalary::with('employee:id,name')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('payment_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('payment_date', [$fromDate, $toDate]))
            ->when($search['employee_id'] != null, fn($query) => $query->where('employee_id', $search['employee_id']))
            ->where('company_id', $admin->active_company_id)
            ->get();

        $totalSalary = $salaryReportRecords->sum('amount');

        $salaryReportData =  $salaryReportRecords->map(function ($salary) use (&$SL) {
            return [
                'SL' => ++$SL,
                'Employee' => optional($salary->employee)->name,
                'Amount' => $salary->amount,
                'Date Of Payment' => customDate($salary->payment_date),
            ];
        });

        $salaryReportData->push([
            'Sl' => '',
            'Total Salary' => 'Total Salary',
            'Amount' => $totalSalary,
        ]);

        return $salaryReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Employee',
            'Amount',
            'Date Of Payment',
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
