<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawItemPurchaseStock extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function rawItem(){
        return $this->belongsTo(RawItem::class, 'raw_item_id', 'id');
    }

}


