<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rawItem(){
        return $this->belongsTo(RawItem::class, 'raw_item_id', 'id');
    }

    public function rawItemStock(){
        return $this->belongsTo(RawItemPurchaseStock::class, 'raw_item_id', 'raw_item_id');
    }

}
