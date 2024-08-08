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
            // Ambil invoice terakhir berdasarkan bagian numerik dari invoice_number
            $lastInvoice = self::orderByRaw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(invoice_number, "/", 2), "/", -1) AS UNSIGNED) DESC')->first(['invoice_number']);

            // Inisialisasi nextID
            if ($lastInvoice) {
                // Ambil angka setelah 'KWITANSI/' dan sebelum '/'
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
            $invoiceNumber = 'KWITANSI/' . sprintf('%03d', $nextID) . '/ABD/' . $currentDate . '/' . $romanMonth . '/' . $currentYear;

            // Set nomor invoice ke model
            $model->invoice_number = $invoiceNumber;
        });
    }

}
