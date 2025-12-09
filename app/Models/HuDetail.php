<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HuDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_import_log_id',
        'shipment_number',
        'ship_to',
        'ship_to_party_text',
        'erp_document',
        'total_weight',
        'weight_unit',
        'total_volume',
        'handling_units',
    ];

    public function fileImportLog()
    {
        return $this->belongsTo(FileImportLog::class);
    }
}
