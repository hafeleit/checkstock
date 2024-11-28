<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHAASD_INV extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางที่ใช้ในฐานข้อมูล
    protected $table = 'ZHAASD_INV';

    // กำหนดให้ฟิลด์ทั้งหมดสามารถกรอกข้อมูลได้
    protected $fillable = [
        'sold_to_party',
        'invoiced_quantity',
        'name',
        'billing_document',
        'billing_type',
        'po_number',
        'billing_date',
        'created_on',
        'item',
        'material',
        'description',
        'sales_unit',
        'net_value',
        'gross_value',
        'posting_status',
        'short_descript',
        'postal_code',
        'city',
        'rebate_group',
        'customer_state',
        'sales_office',
        'sales_rep',
        'name2',
        'product_hierarchy',
        'country_key',
        'name3',
        'document_currency',
        'sddocumentcateg',
        'higher_levelite',
        'sales_document',
    ];

    // ตัวเลือกถ้าต้องการจัดการ timestamps อัตโนมัติ
    public $timestamps = true;
}
