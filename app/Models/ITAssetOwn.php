<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ITAssetOwn extends Model
{
    use HasFactory;

    protected $fillable = [
      'computer_name',
      'user',
      'main',
      'status',
    ];

    public function userMaster()
    {
      return $this->belongsTo(UserMaster::class, 'user', 'job_code');
    }

    public function getOwnerAttribute()
    {
      return UserMaster::where('status', 'Current')
        ->where(function ($q) {
          $q->where('employee_code', $this->user)
            ->orWhere('job_code', $this->user);
        })
        ->first();
    }
}
