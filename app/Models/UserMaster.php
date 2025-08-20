<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMaster extends Model
{
    use HasFactory;

    protected $fillable = [
      'employee_code',
      'division',
      'manager',
      'status',
      'employment_date',
      'effecttive_date',
      'job_title',
      'uuid',
      'job_code',
      'name_en',
      'name_th',
      'dept',
      'position',
      'location',
      'email',
    ];
}
