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
      'format_id',
      'supplier_code',
      'supplier_item',
      'type',
      'format',
      'model',
      'price',
      'hafele_addr',
      'manf_date',
      'country_code',
      'defrosting',
      'gross_int',
      'nominal_voltage',
      'nominal_freq',
      'defrosting_power',
      'nominal_electricity',
      'max_power_of_lamp',
      'electric_power_phase',
      'nominal_power',
      'star_rating_freezer',
      'energy_cons_per_year',
      'climate_class',
      'refrigerant',
      'tis_1',
      'tis_2',
      'series_name',
      'qr_code',
      'color',
      'status',

    ];
}
