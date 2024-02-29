<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCenter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }

    public function upazila(){
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }

    public function union(){
        return $this->belongsTo(Union::class, 'union_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function affiliateMembers(){
        return $this->hasMany(AffiliateMemberSalesCenter::class, 'sales_center_id');
    }

}
