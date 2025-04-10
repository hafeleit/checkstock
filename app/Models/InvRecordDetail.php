<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvRecordDetail extends Model
{
    use HasFactory;

    protected $fillable = ['inv_record_id', 'inv_number', 'status', 'approve', 'approve_date'];
}
