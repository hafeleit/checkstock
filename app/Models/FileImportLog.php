<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_size',
        'type',
        'status',
        'created_by'
    ];
}
