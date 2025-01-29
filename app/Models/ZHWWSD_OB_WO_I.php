<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWSD_OB_WO_I extends Model
{
    use HasFactory;

    protected $table = 'ZHWWSD_OB_WO_I';

    protected $fillable = [
        'SalesDoc',
        'Sold_topt',
        'Plnt',
        'Material',
        'Item',
        'Cost',
        'Curr',
        'FollOndoc',
        'ExternalDeliveryID',
        'Createdon',
    ];
}
