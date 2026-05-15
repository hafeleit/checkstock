<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HthContactCenter extends Model
{
    use HasFactory;

    protected $connection = 'crm';
    protected $table = 'hth_contact_center';
}
