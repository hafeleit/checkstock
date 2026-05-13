<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZHWWBCQUERYDIR extends Model
{
    use HasFactory;

    protected $connection = "external_mysql";
    protected $table = "ZHWWBCQUERYDIR";
}
