<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_order',
        'id_product',
        'description',
        'days',
        'qty',
        'measure_list',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id_order', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'id_product', 'id');
    }

}
