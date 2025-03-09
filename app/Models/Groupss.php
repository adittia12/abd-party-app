<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupss extends Model
{
    use HasFactory;

    protected $table = 'groupss';
    protected $fillable = [
        'name_group'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function employees()
    {
        return $this->hasMany(Employes::class, 'id_group');
    }
}
