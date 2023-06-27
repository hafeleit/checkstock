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
      'ITEM_NAME_TH',
      'ITEM_STATUS',
      'ITEM_INVENTORY_CODE',
      'ITEM_BRAND',
      'ITEM_UOM_CODE',
      'ITEM_GRADE_CODE_1',
      'ITEM_GRADE_CODE_2',
      'CURRWAC',
      'PRODUCT_CATEGORY',
      'PRODUCT_GROUP',
      'PRODUCT_AIS',
      'ITEM_REPL_TIME',
      'SAI_SA_SUPP_CODE',
      'PURCHASER_NAME',
      'PM_NAME',
      'SALES_CATEGORY',
      'STOCK_IN_HAND',
      'PENDING_SO',
      'AVAILABLE_STOCK',
      'NEW_ITEM',
      'PROJECT_ITEM',
      'PRICE_LIST_UOM',
      'PACK_CONV_FACTOR',
      'RATE',
      'RATE7',
      'STATUS',
      'DEL',
    ];
}
