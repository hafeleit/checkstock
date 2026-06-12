<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSeries extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['series_name', 'item_code', 'item_base', 'updated_by'];

    protected $casts = ['item_base' => 'boolean'];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
