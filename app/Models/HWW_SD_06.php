<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HWW_SD_06 extends Model
{
    use HasFactory;

    protected $table = 'HWW_SD_06';

    protected $fillable = [
        'SalesDoc', 'Createdat', 'Z_MM_JJJJ', 'C', 'Type',
        'SOrg', 'SOff', 'Sold_to', 'Cty', 'Name', 'City',
        'Ship_to', 'Name2', 'Cty2', 'Item', 'ICat', 'Plant',
        'SPlt', 'Material', 'OrderQuantity', 'SU', 'NetValue',
        'Curr', 'Cost', 'Curr2', 'ZC', 'ZE', 'ZI', 'ZO',
        'Createdby', 'RR', 'ProductHierarchy', 'ProdHIII',
        'ProdHIIIName', 'Status', 'POtyp'
    ];

    public $timestamps = true;
}
