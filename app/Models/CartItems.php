<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function item(){
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function sale(){
        return $this->belongsTo(Sale::class, 'sales_id');
    }
}
