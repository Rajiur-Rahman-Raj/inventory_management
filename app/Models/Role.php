<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'permission' => 'object'
    ];

    protected static function booted(): void
    {
        static::creating(function (Role $role) {
            $role->created_by = auth()->id();
        });

        static::updating(function (Role $role){
            $role->updated_by = auth()->id();
        });
    }

    public function roleUsers()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
