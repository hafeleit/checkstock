<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvTracking extends Model
{
    use HasFactory;
    protected $fillable = [
        'logi_track_id',
        'erp_document',
        'invoice_id',
        'driver_or_sent_to',
        'type',
        'status',
        'delivery_date',
        'created_date',
        'created_by',
        'updated_by',
        'remark'
    ];
    protected $casts = [
        'delivery_date' => 'datetime',
        'created_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
