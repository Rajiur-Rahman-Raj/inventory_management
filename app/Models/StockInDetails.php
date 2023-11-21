<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $totalItemCost = 0;
    public function __construct()
    {
       $this->totalItemCost = 0;
    }

    public function item(){
        return $this->belongsTo(Item::class, 'item_id');
    }


}
