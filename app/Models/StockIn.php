<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function stockInDetails(){
        return $this->hasMany(StockInDetails::class, 'stock_in_id');
    }
}
