<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZMM_MATZERT extends Model
{
    use HasFactory;

    // ชื่อของตารางในฐานข้อมูล
    protected $table = 'ZMM_MATZERT';

    // ฟิลด์ที่อนุญาตให้ทำการบันทึกข้อมูลได้ (mass assignable)
    protected $fillable = [
        'material',
        'supplier',
        'purch_organization',
        'certificate',
        'norm_and_flag',
        'testing_institute',
        'certificate_key1',
        'valid_to',
        'lead_time_in_days',
        'date_of_issue',
        'coverage',
        'certificate_key',
    ];
}
