<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HthAssSurvey extends Model
{
    use HasFactory;

    protected $connection = 'crm';
    protected $table = 'hth_ass_survey';
}
