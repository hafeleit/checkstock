<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLColour extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_colours';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'colour_code',
        'colour_description',
    ];

    public $timestamps = true;
}
