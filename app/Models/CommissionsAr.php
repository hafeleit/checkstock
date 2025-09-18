<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionsAr extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'commissions_id',
        'type',
        'account',
        'name',
        'document_type',
        'reference',
        'reference_key',
        'document_date',
        'clearing_date',
        'amount_in_local_currency',
        'local_currency',
        'clearing_document',
        'text',
        'posting_key',
        'sales_rep',

        'cn_billing_ref',
        'cn_sales_doc',
        'cn_order_date',
        'cn_no',
        'cn_date',
        'cn_sales_name',
        'cn_tax_invoice',
        'cn_sales_doc_name',

        'ar_rate',
        'ar_rate_percent',
        'commissions',
        'status',
        'adjuster',
        'remark',
    ];
}
