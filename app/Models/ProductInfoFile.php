<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfoFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'type',
        'path',
        'file_name',
        'updated_by'
    ];
}
