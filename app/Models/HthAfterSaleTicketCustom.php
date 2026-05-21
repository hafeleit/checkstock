<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HthAfterSaleTicketCustom extends Model
{
    use HasFactory;

    protected $connection = 'crm';
    protected $table = 'hth_after_sale_ticket_cstm';
}
