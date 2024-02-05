<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawItemPurchaseIn extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (RawItemPurchaseIn $rawItemPurchaseIn) {
            $rawItemPurchaseIn->created_by = auth()->id();
        });

        static::updating(function (RawItemPurchaseIn $rawItemPurchaseIn){
            $rawItemPurchaseIn->updated_by = auth()->id();
        });
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function rawItemDetails(){
        return $this->hasMany(RawItemPurchaseInDetails::class, 'raw_item_purchase_in_id');
    }

    public function purchasePayments(){
        return $this->hasMany(PurchaseRawItemMakePayment::class, 'raw_item_purchase_in_id');
    }
}
