<?php

namespace App\Services;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\ManageProperty;
use Carbon\Carbon;


class NotifyMailService
{
    use Upload, Notify;

    public function investmentProfit($request, $user, $investment, $basic, $transaction, $amount = null){

        $property = ManageProperty::with(['details'])->find($investment->property_id);        
    }

    public function investmentCapitalBack($user, $investment, $basic, $transaction, $capital){
        $property = ManageProperty::with(['details'])->find($investment->property_id);
        
    }
}
