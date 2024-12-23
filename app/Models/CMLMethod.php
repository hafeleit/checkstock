<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLMethod extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_methods';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'method_code',
        'method_description',
    ];

    public $timestamps = true;
}
