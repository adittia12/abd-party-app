<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class OperationalMoney extends Model
{
    use HasFactory;

    protected $table = 'operational_money';

    protected $fillable = [
        'code_operational',
        'tgl_opartional',
        'name_operational',
        'budget',
        'time_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transaction_oprational()
    {
        return $this->hasMany(TransactionOperational::class, 'id_operational', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(TransactionOperational::class, 'id_operasional', 'id');
    }


    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            do {
                $symbols = '!@#$%^&*()'; // Simbol yang digunakan
                $randomString = Str::random(6); // Huruf besar/kecil dan angka (6 karakter)
                $randomSymbols = substr(str_shuffle($symbols), 0, 2); // Simbol acak (2 karakter)

                // Gabungkan string dan simbol, lalu acak ulang
                $transactionCode = str_shuffle($randomString . $randomSymbols);

                // Pastikan panjang persis 8 karakter dan unik
            } while (strlen($transactionCode) !== 8 || self::where('code_operational', $transactionCode)->exists());

            // Set kode transaksi ke model
            $model->code_operational = $transactionCode;
        });
    }
}
