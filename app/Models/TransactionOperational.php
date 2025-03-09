<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionOperational extends Model
{
    use HasFactory;

    protected $table = 'transaction_oprational';

    protected $fillable = [
        'id_operational',
        'id_employe',
        'id_list_budget',
        'expend',
        'tgl_periode'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function operational_money()
    {
        return $this->belongsTo(OperationalMoney::class, 'id_operational', 'id');
    }

    public function employess()
    {
        return $this->belongsTo(Employes::class, 'id_employe', 'id');
    }
    // Tambahkan relasi ke ListBudgetModel
    public function listBudget()
    {
        return $this->belongsTo(ListBudgetModel::class, 'id_list_budget', 'id');
    }
}
