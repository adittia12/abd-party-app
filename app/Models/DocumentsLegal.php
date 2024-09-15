<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsLegal extends Model
{
    use HasFactory;

    protected $table = 'documents_legal';

    protected $fillable = [
        'title',
        'document'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
