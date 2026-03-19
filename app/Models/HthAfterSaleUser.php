<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HthAfterSaleUser extends Model
{
    use HasFactory;

    protected $connection = 'crm';
    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;
}
