<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ITAssetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_code',
        'type_desc',
        'type_status',
    ];
}
