<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMLSuggestion extends Model
{
    use HasFactory;

    // ชื่อของตาราง
    protected $table = 'cml_suggestions';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูล
    protected $fillable = [
        'suggestion_code',
        'suggestion_description',
    ];

    public $timestamps = true;
}
