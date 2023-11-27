<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'items' => 'array',
    ];

    public function salesCenter(){
        return $this->belongsTo(SalesCenter::class, 'sales_center_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
