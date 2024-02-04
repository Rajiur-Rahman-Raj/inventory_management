<?php

namespace App\Exports;

use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExpenseReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        $expenseReportRecords = Expense::with('expenseCategory:id,name')
            ->when(isset($search['from_date']), fn($query) => $query->whereDate('expense_date', '>=', $fromDate))
            ->when(isset($search['to_date']), fn($query) => $query->whereBetween('expense_date', [$fromDate, $toDate]))
            ->when($search['expense_category_id'] != null, fn($query) => $query->where('category_id', $search['expense_category_id']))
            ->where('company_id', $admin->active_company_id)
            ->get();

        $totalExpense = $expenseReportRecords->sum('amount');

        $expenseReportData =  $expenseReportRecords->map(function ($expense) use (&$SL) {
            return [
                'SL' => ++$SL,
                'Expense Head' => $expense->expenseCategory->name,
                'Amount' => $expense->amount,
                'Date Of Expense' => customDate($expense->expense_date),
            ];
        });

        $expenseReportData->push([
            'Sl' => '',
            'Total Expense' => 'Total Expense',
            'Amount' => $totalExpense,
        ]);

        return $expenseReportData;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Expense Head',
            'Amount',
            'Date Of Expense',
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
