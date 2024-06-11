<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'company_type',
        'name_customer',
        'no_phone',
        'invoice_address',
        'delivery_address',
        'initial_terms',
        'jenis_term',
        'start_event',
        'end_event',
        'date_pasang',
        'warehouse',
        'price_list',
        'close_date',
        'discount_rate',
        'dp',
        'status_order',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function transaction()
    {
        return $this->hasMany('id_order');
    }
}
