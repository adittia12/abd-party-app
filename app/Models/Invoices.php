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

            // Ambil tahun dari invoice terakhir jika ada
            $lastYear = null;
            if ($lastInvoice) {
                // Ambil tahun dari nomor invoice terakhir
                $lastYear = substr($lastInvoice->invoice_number, strrpos($lastInvoice->invoice_number, '/') + 1);
            }

            // Ambil tahun saat ini
            $currentYear = Carbon::now()->format('Y');

            // Jika tahun sekarang berbeda dengan tahun terakhir, reset nextID menjadi 1
            if ($lastYear !== $currentYear) {
                $nextID = 1;
            } else {
                // Inisialisasi nextID berdasarkan invoice terakhir
                $nextID = 1;
                if ($lastInvoice) {
                    // Ambil angka setelah 'KWITANSI/' dan sebelum '/'
                    $latestID = intval(substr($lastInvoice->invoice_number, strlen('KWITANSI/'), strpos($lastInvoice->invoice_number, '/', strlen('KWITANSI/')) - strlen('KWITANSI/')));
                    $nextID = $latestID + 1;
                }
            }

            // Ambil tanggal saat ini menggunakan Carbon
            $currentDate = Carbon::now()->format('d');
            $currentMonth = Carbon::now()->format('m');

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
