<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWMM_BOM_VKO extends Model
{
    use HasFactory;

    protected $table = 'zhwwmm_bom_vko';

    public function spareparts()
    {
        return $this->belongsTo(ZHWWBCQUERYDIR::class, 'component', 'material');
    }
}
