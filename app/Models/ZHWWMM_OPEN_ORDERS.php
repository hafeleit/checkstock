<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWMM_OPEN_ORDERS extends Model
{
    use HasFactory;

    protected $table = 'ZHWWMM_OPEN_ORDERS';

    protected $fillable = [
        'purch_organization',
        'purchasing_document',
        'item',
        'created_on_purchasing_doc',
        'purchasing_doc_type',
        'purchasing_group',
        'supplier',
        'deletion_indicator',
        'material',
        'short_text',
        'plant',
        'quantity_po',
        'po_order_unit',
        'net_order_value',
        'currency',
        'vendor_output_date',
        'confirmed_issue_date',
        'confirmed_delivery_date',
        'scheduled_quantity',
        'quantity_oc',
        'oc_order_unit_2',
        'open_inv_quantity_po_item',
        'delivered_quantity',
        'sold_to_party',
        'purchase_order_no',
        'ehk_po_strategy',
        'usages',
        'delivery_completed',
    ];

    // Optional: If you want to automatically handle timestamps, use the following
    public $timestamps = true;
}
