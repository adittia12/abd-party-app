<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkforeceSkills extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
