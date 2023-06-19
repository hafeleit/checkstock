<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      'ITEM_CODE',
      'ITEM_NAME',
      'ITEM_STATUS',
      'ITEM_INVENTORY_CODE',
      'ITEM_REPL_TIME',
      'ITEM_GRADE_CODE_1',
      'ITEM_UOM_CODE',
      'PACK_CONV_FACTOR',
      'PACK_PARENT_UOM_CODE',
      'LOCN_CODE',
      'LOCN_NAME',
      'FREESTOCK',
      'RATE',
      'NEW_ITEM',
      'STATUS',
      'DEL',
    ];
}
