<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLDefrosting extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_defrostings';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'defrosting_code',
        'defrosting_description',
    ];

    public $timestamps = true;
}
