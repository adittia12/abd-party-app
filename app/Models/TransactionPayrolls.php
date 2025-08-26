<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPayrolls extends Model
{
    use HasFactory;

    protected $table = 'transaction_payrolls';

    protected $fillable = [
        'id_periode_pay',
        'id_employe',
        'id_trans_operational_kasbon',
        'payroll',
        'another_piece',
        'desc_payroll',
        'list_payroll'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function periode()
    {
        return $this->belongsTo(PayrollPeriod::class, 'id_periode_pay');
    }

    public function employe()
    {
        return $this->belongsTo(Employes::class, 'id_employe');
    }

    public function group()
    {
        return $this->hasOneThrough(Groupss::class, Employes::class, 'id_group', 'id', 'id_employe', 'id');
    }

    public function operational()
    {
        return $this->belongsTo(TransactionOperational::class, 'id_trans_operational_kasbon');
    }
}
