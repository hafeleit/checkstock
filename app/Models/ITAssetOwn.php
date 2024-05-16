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
}
