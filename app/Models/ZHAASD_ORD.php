<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHAASD_ORD extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางที่ใช้ในฐานข้อมูล
    protected $table = 'ZHAASD_ORD';

    // กำหนดให้ฟิลด์ทั้งหมดสามารถกรอกข้อมูลได้
    protected $fillable = [
        'sd_document',
        'item',
        'doc_type',
        'material',
        'customer_material',
        'req_del_qty',
        'delivered_qty',
        'sales_unit',
        'description',
        'req_del_date',
        'conf_del_date',
        'comment',
        'availability',
        'days_delayed',
    ];

    // ตัวเลือกถ้าต้องการจัดการ timestamps อัตโนมัติ
    public $timestamps = true;
}
