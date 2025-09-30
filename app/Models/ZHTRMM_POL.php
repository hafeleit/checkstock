<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHTRMM_POL extends Model
{
    use HasFactory;

    protected $table = "zhtrmm_pol";
    protected $fillable = [
        "purch_doc",
        "po_doc_date",
        "material",
        "order_quantity",
        "scheduled_quantity",
        "order_unit",
        "st_prod_time",
        "planned_delivery_time",
        "status",
        "po_prod_time",
        "po_exp_out_date",
        "cf_exp_out_date",
        "inb_act_arrival_date",
        "confirm_category"
    ];
}
