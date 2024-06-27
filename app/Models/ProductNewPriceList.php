<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductNewPriceList extends Model
{
    use HasFactory;

    protected $fillable = [
      'ITEM_CODE',
      'PRICE',
    ];
}
