<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $table = "payroll_period";
    protected $fillable = [
        'month_period'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
