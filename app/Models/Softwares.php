<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Softwares extends Model
{
    use HasFactory;

    protected $fillable = [
      'computer_name',
      'software_name',
      'license_type',
      'license_expire_date',
    ];
}
