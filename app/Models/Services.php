<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function photo_service()
    {
        return $this->hasMany(PhotoService::class, 'id_service');
    }
}
