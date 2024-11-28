<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWBCQUERYDIR_PUR extends Model
{
    use HasFactory;

    protected $table = 'ZHWWBCQUERYDIR_PUR';

    protected $fillable = [
        'purch_doc',
        'item',
        'plnt',
        'cocd',
        'c',
        'type',
        'created_on',
        'created_by',
        'vendor',
        'payt',
        'pgr',
        'pgr_crcy',
        'exch_rate',
        'ship_type',
        'ehk_po_strategy',
        'd',
        'material',
        'po_quantity',
        'oun',
        'oun1',
        'short_text',
        'vendor_material_number',
        'eq_to',
        'denom',
        'dci',
        'net_value',
        'net_value_crcy',
        'per',
        'net_price',
        'net_price_crcy',
        'i',
        'l_ship_type',
        'product_specification',
        'mtyp',
        'vdr_outpdate',
        'production_time_in_days',
        'transport_time_in_days',
        'usages',
        'purchase_order_number',
        'customer',
        'reference_to_other_vendor',
        'a',
        'sloc',
        'advanced_po',
    ];
}
