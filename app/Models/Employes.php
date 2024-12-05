<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employes extends Model
{
    use HasFactory;

    protected $table = 'employess';

    protected $fillable = [
        'id_group',
        'code_employe',
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // Mendapatkan code_employe terakhir berdasarkan urutan terbesar
            $lastEmploye = self::orderBy('code_employe', 'desc')->first();

            // Jika data tersedia, ambil angka ID terakhir, jika tidak mulai dari 1
            $lastID = $lastEmploye ? intval(substr($lastEmploye->code_employe, 2)) : 0;
            $nextID = $lastID + 1;

            // Set code_employe dengan format 'NP' dan angka 5 digit
            do {
                $model->code_employe = 'NP' . sprintf("%05d", $nextID++);
            } while (self::where('code_employe', $model->code_employe)->exists());
        });
    }

}
