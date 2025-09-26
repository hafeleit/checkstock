<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETaxForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_channel',
        'other_channel',
        'order_ref',
        'customer_name',
        'phone',
        'tax_id',
        'branch_id',
        'email',
        'address_line1',
        'address_line2',
        'province',
        'zip_code',
        'shipping_address_same',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_province',
        'shipping_zip_code',
        'pdpa_consent',
    ];
}
