<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWBCQUERYDIR extends Model
{
  use HasFactory;

  // ระบุชื่อ table ชัดเจน
  protected $table = 'ZHWWBCQUERYDIR';

  // ระบุฟิลด์ที่สามารถ fill ได้
  protected $fillable = [
    'material',
    'language',
    'kurztext',
    'angelegta',
    'mtyp',
    'ms',
    'bun',
    'plnt',
    'dm',
    'mrp',
    'lage',
    'model_number',
    'model_name',
    'angel_vo',
    'reason_for_requirement',
    'requestor',
    'vertriebss',
    'werksspez',
    'total_stock',
    'unrestricted',
    'unrestricted_bun',
    'aver_qua_art',
    'aver_qua_art_bun',
    'rounding_val',
    'rounding_val_bun',
    'm',
    'm2',
    'e',
    'b',
    'so',
    'pgr',
    'mrpcn',
    'pdt',
    'war',
    'code_number',
    'orig',
    'ror',
    'a',
    'x',
    'erstverkau',
    'product_group_manager',
    'data_manager',
    'safety_stock',
    'safety_stock_bun',
    'aun',
    'numer',
    'denom',
    'length',
    'length_uod',
    'width',
    'width_uod',
    'height',
    'height_uod',
    'gross_weight',
    'wun',
    'volume',
    'vun',
    'ean_upc',
    'sloc',
    'brand',
    'product_hierarchy_local',
    'product_hierarchy_global',
    'product_hierarchy_bun',
    'package_unit',
    'delivery_unit',
    'posi',
    'tradesmanpu',
    'k',
    'we',
    'st',
    'su',
    'mov_avg_price',
    'crcy1',
    'standard_price',
    'crcy2',
    'per',
    'valcl',
  ];

  public function  zmm_matzert()
  {
    return $this->hasOne(ZMM_MATZERT::class, 'material', 'material');
  }

  public function product_info()
  {
    return $this->hasOne(ProductInfo::class, 'item_code', 'material');
  }

  public function imageFile()
  {
    return $this->hasOne(ProductInfoFile::class, 'item_code', 'material')
      ->where('type', 'image');
  }

  public function catalogueFiles()
  {
    return $this->hasMany(ProductInfoFile::class, 'item_code', 'material')
      ->where('type', 'catalogue');
  }

  public function manualFiles()
  {
    return $this->hasMany(ProductInfoFile::class, 'item_code', 'material')
      ->where('type', 'manual');
  }

  public function specsheetFiles()
  {
    return $this->hasMany(ProductInfoFile::class, 'item_code', 'material')
      ->where('type', 'specsheet');
  }
}
