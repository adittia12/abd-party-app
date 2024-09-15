<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentars extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
