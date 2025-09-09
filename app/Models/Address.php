<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_import_log_id',
        'delivery',
        'name',
        'street',
        'city',
        'postal_code'
    ];

    public function fileImportLog()
    {
        return $this->belongsTo(FileImportLog::class);
    }
}
