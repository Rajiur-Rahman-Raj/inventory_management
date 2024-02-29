<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateMemberCommission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function affiliateMember(){
        return $this->belongsTo(AffiliateMember::class, 'affiliate_member_id');
    }
}
