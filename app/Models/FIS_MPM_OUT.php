<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FIS_MPM_OUT extends Model
{
    use HasFactory;

    protected $table = 'FIS_MPM_OUT';

     protected $fillable = [
         'MATNR',
         'TDOBJECT',
         'TDID',
         'TDSPRAS',
         'VKORG',
         'VTWEG',
         'ZEILE',
         'TDFORMAT',
         'TDLINE',
     ];
}
