<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralPromoterCommission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function centralPromoter(){
        return $this->belongsTo(CentralPromoter::class, 'central_promoter_id', 'id');
    }


}
