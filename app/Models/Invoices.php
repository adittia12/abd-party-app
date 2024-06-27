<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_order',
        'invoice_number',
        'no_po_manual',
        'period_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // Ambil invoice terakhir
            $lastInvoice = self::orderBy('invoice_number', 'desc')->first(['invoice_number']);

            // Inisialisasi nextID
            if ($lastInvoice) {
                // Ambil angka setelah 'KWITANSI' dan sebelum '/'
                $latestID = intval(substr($lastInvoice->invoice_number, strlen('KWITANSI/'), strpos($lastInvoice->invoice_number, '/', strlen('KWITANSI/')) - strlen('KWITANSI/')));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }

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

            // Bentuk nomor invoice sesuai format
            $model->invoice_number = 'KWITANSI/' . sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;

            // Cek keunikan invoice number
            while (self::where('invoice_number', $model->invoice_number)->exists()) {
                $nextID++;
                $model->invoice_number = 'KWITANSI/' . sprintf('%02d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;
            }
        });
    }
}
