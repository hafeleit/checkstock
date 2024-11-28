<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHINSD_VA05 extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางที่ใช้ในฐานข้อมูล
    protected $table = 'ZHINSD_VA05';

    // กำหนดให้ฟิลด์ทั้งหมดสามารถกรอกข้อมูลได้
    protected $fillable = [
        'sd_document',
        'item_sd',
        'description',
        'sales_document_type',
        'document_date',
        'confirmed_quantity',
        'purchase_order_no',
        'delivery_date',
        'created_by',
        'billing_block',
        'sold_to_party',
        'order_quantity',
        'material',
        'base_unit_of_measure',
        'name1',
        'cust_expected_price',
        'net_price',
        'pricing_unit',
        'unit_of_measure',
        'net_value',
        'division',
        'status',
        'sales_office',
        'sales_group',
        'sales_organization',
        'sales_unit',
        'shipping_point_receiving_pt',
        'distribution_channel',
        'goods_issue_date',
        'document_currency',
        'plant',
        'order_quantity_2',
        'probability',
        'sold_to_address',
        'sd_document_categ',
        'pricing_date',
        'created_on',
        'time',
        'reason_for_rejection',
    ];

    // ตัวเลือกถ้าต้องการจัดการ timestamps อัตโนมัติ
    public $timestamps = true;
}
