<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLWarning extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_warnings';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'warning_code',
        'warning_description',
    ];

    public $timestamps = true;
}
