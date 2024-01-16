<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (Expense $expense) {
            $expense->created_by = auth()->id();
        });

        static::updating(function (Expense $expense){
            $expense->updated_by = auth()->id();
        });
    }

    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id');
    }

}
