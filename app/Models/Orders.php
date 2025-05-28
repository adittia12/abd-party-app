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
        'pajak_pph',
        'pajak_ppn',
        'descript_payment',
        'pembayaran',
        'status_order',
        'status_driver',
        'date_driver',
        'payment_type'
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

            // Ambil tahun dan nomor urut dari order terakhir
            $lastOrderYear = $getOrder ? substr($getOrder->order_number, strrpos($getOrder->order_number, '/') + 1) : null;

            // Tentukan ID berikutnya, reset ID jika tahun berbeda
            $currentYear = Carbon::now()->format('Y');
            if ($lastOrderYear !== $currentYear) {
                $nextID = 1;  // Jika tahun berubah, reset ke 1
            } else {
                $nextID = $getOrder ? intval(substr($getOrder->order_number, 0, strpos($getOrder->order_number, '/'))) + 1 : 1;
            }

            // Ambil tanggal saat ini menggunakan Carbon
            $currentDate = Carbon::now()->format('d');
            $currentMonth = Carbon::now()->format('m');

            // Daftar bulan Romawi
            $romanMonths = [
                '01' => 'I',
                '02' => 'II',
                '03' => 'III',
                '04' => 'IV',
                '05' => 'V',
                '06' => 'VI',
                '07' => 'VII',
                '08' => 'VIII',
                '09' => 'IX',
                '10' => 'X',
                '11' => 'XI',
                '12' => 'XII'
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
