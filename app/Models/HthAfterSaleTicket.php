<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HthAfterSaleTicket extends Model
{
    use HasFactory;

    protected $connection = 'crm';
    protected $table = 'hth_after_sale_ticket';

    public function assignee()
    {
        return $this->belongsTo(HthAfterSaleUser::class, 'assigned_user_id', 'id');
    }
}
