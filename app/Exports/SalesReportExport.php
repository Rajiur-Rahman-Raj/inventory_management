<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($request){
        $this->request = $request;
    }

    public function collection()
    {
        return Sale::all();
    }
}