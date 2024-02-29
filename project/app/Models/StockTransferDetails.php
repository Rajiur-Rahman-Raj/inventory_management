<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function stocks(){
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }

}
