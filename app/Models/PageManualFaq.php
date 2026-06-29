<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageManualFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_identifier',
        'question',
        'answer',
        'pdf_file_path',
        'sequence',
        'updated_by',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
