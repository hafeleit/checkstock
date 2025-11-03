<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ITAssetType extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'type_code',
        'type_desc',
        'type_status',
    ];
}
