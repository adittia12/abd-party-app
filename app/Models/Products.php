<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'inter_ref',
        'name_product',
        'sales_price',
        'unit_measure',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function transaction()
    {
        return $this->hasMany(Transactions::class, 'id_product');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $getProduct = self::orderBy('inter_ref', 'desc')->first();

            if ($getProduct) {
                $latestID = intval(substr($getProduct->inter_ref, 5));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }

            $model->inter_ref = 'AB' . sprintf("%05s", $nextID);
            while (self::where('inter_ref', $model->inter_ref)->exists()) {
                $nextID++;
                $model->inter_ref = 'AB' . sprintf("%05s", $nextID);
            }
        });
    }
}
