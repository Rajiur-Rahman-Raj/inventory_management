<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateMemberSalesCenter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function salesCenter(){
        return $this->belongsTo(SalesCenter::class, 'sales_center_id', 'id');
    }

}
