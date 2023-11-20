<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function item($itemId){
        $item = Item::findOrFail($itemId);
        return $item;
    }

}
