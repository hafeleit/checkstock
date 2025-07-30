<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_id',
        'status',
        'hr_comment',
        'fin_comment',
        'delete',
        'create_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'create_by');
    }
}
