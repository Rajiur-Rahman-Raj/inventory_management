<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['item_price_route'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function getItemPriceRouteAttribute()
    {
        return route('user.updateItemUnitPrice', $this->id);
    }
}
