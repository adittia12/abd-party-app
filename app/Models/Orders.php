<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'tgl_order',
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

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $getOrder = self::orderBy('order_number', 'desc')->first();

            if ($getOrder) {
                $latestID = intval(substr($getOrder->order_number, 0, strpos($getOrder->order_number, '/')));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }

            // Ambil tanggal saat ini
            $currentDate = date('d');
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Daftar bulan Romawi
            $romanMonths = [
                '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
                '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
                '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
            ];

            // Format bulan menjadi Romawi
            $romanMonth = $romanMonths[$currentMonth];

            // Bentuk nomor order sesuai format
            $model->order_number = sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;

            while (self::where('order_number', $model->order_number)->exists()) {
                $nextID++;
                $model->order_number = sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;
            }
        });
    }
}
