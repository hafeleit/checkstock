<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHAAMM_IFVMG extends Model
{
    use HasFactory;

    // ชื่อของตารางในฐานข้อมูล
    protected $table = 'ZHAAMM_IFVMG';

    // ฟิลด์ที่อนุญาตให้ทำการบันทึกข้อมูลได้ (mass assignable)
    protected $fillable = [
        'purch_organization',
        'supplier',
        'material',
        'vendor_material_number',
        'ean_upc',
        'country_of_origin',
        'order_unit',
        'minimum_order_qty',
        'planned_deliv_time',
    ];
}
