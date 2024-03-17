<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function salesCenter(){
        return $this->hasMany(SalesCenter::class, 'company_id', 'id');
    }

    public function suppliers(){
        return $this->hasMany(Supplier::class, 'company_id', 'id');
    }

    public function centralPromoter(){
        return $this->hasOne(CentralPromoter::class, 'company_id', 'id');
    }
}
