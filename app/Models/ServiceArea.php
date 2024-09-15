<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    use HasFactory;

    protected $table = 'services_area';

    protected $fillable = [
        'area'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
