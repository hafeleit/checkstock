<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQrCode extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'id',
        'customer_name',
        'customer_full_name',
        'customer_code',
        'qr_payload',
        'amount',
        'created_date',
        'created_by',
        'file_import_log_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
