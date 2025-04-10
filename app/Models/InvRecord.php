<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvRecord extends Model
{
    use HasFactory;

    protected $fillable = ['sheet_id', 'invoice_number', 'creator', 'status'];
}
