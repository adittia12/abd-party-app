<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBudgetModel extends Model
{
    use HasFactory;

    protected $table = "list_bugeting";

    protected $fillable = [
        'list_budget'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
