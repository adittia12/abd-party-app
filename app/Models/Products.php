<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'inter_ref',
        'name_product',
        'sales_price',
        'unit_measure',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // public function transaction()
    // {
    //     return $this->hasMany(Employees::class, 'id_product');
    // }
}
