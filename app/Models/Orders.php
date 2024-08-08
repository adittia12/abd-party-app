<?php

namespace App\Models;

use Carbon\Carbon;
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
        'jenis_pajak',
        'pajak',
        'status_order',
        'status_driver'
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
        self::creating(function ($model) {
            // Ambil order terbaru berdasarkan nomor urut (sebelum '/ABD/')
            $getOrder = self::orderByRaw('CAST(SUBSTRING_INDEX(order_number, "/", 1) AS UNSIGNED) DESC')->first();

            // Tentukan ID berikutnya
            $nextID = $getOrder ? intval(substr($getOrder->order_number, 0, strpos($getOrder->order_number, '/'))) + 1 : 1;

            // Ambil tanggal saat ini menggunakan Carbon
            $currentDate = Carbon::now()->format('d');
            $currentMonth = Carbon::now()->format('m');
            $currentYear = Carbon::now()->format('Y');

            // Daftar bulan Romawi
            $romanMonths = [
                '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
                '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
                '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
            ];

            // Format bulan menjadi Romawi
            $romanMonth = $romanMonths[$currentMonth];

            // Bentuk nomor order sesuai format
            $orderNumber = sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;

            // Pastikan nomor order unik
            while (self::where('order_number', $orderNumber)->exists()) {
                $nextID++;
                $orderNumber = sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;
            }

            // Set nomor order ke model
            $model->order_number = $orderNumber;
        });
    }

}
