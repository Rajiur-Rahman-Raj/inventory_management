<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['item_price_route', 'update_selling_price_route'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function getItemPriceRouteAttribute()
    {
        return route('user.updateItemUnitPrice', $this->id);
    }

    public function getUpdateSellingPriceRouteAttribute()
    {
        return route('user.updateSellingPrice', $this->id);
    }

    public function salesCenter(){
        return $this->belongsTo(SalesCenter::class, 'sales_center_id');
    }
}
