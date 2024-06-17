<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ITAsset extends Model
{
    use HasFactory;

    protected $fillable = [
      'computer_name',
      'serial_number',
      'type',
      'color',
      'model',
      'fixed_asset_no',
      'purchase_date',
      'warranty',
      'expire_date',
      'status',
      'old_user',
      'old_name',
      'old_department',
      'location',
      'create_by',
      'update_by',
    ];
}
