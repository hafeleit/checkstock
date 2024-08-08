<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
      'bar_code',
      'item_desc_en',
      'suggest_text',
      'made_by',
      'material_text',
      'warning_text',
      'how_to_text',
      'product_name',
      'item_code',
      'grade_code_1',
      'material_color',
      'remark',
      'item_size',
      'item_amout',
      'item_type',
      'factory_name',
      'factory_address',
    ];
}
