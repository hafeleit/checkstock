<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'addr', 
        'tel', 
        'email', 
        'serial_no', 
        'order_channel', 
        'other_channel', 
        'order_number',
        'article_no',
        'file_name', 
        'file_name2', 
        'file_name3', 
        'file_name4', 
        'file_name5',
        'is_consent_policy',
        'is_consent_marketing',
    ];
}
