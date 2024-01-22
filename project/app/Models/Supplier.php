<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            $supplier->created_by = auth()->id();
        });

        static::updating(function (Supplier $supplier){
            $supplier->updated_by = auth()->id();
        });
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
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
