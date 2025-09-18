<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileImportLog extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'file_name',
        'file_size',
        'type',
        'status',
        'created_by'
    ];
}
