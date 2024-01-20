<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateMember extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (AffiliateMember $member) {
            $member->created_by = auth()->id();
        });

        static::updating(function (AffiliateMember $member){
            $member->updated_by = auth()->id();
        });
    }

    public function salesCenter()
    {
        return $this->belongsToMany(SalesCenter::class, 'affiliate_member_sales_centers')->withTimestamps();
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

}
