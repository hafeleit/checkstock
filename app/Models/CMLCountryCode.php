<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLCountryCode extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_country_codes';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'country_code',
        'country_description',
        'country_name_in_thai',
    ];

    public $timestamps = true;
}
