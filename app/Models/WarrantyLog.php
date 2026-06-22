<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_id',
        'action_type',
        'performed_by',
        'old_values',
        'new_values',
        'file_name',
        'record_count',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function getChangedFieldsAttribute(): array
    {
        if ($this->action_type !== 'updated' || empty($this->new_values)) {
            return [];
        }
        $changed = [];
        foreach ($this->new_values as $key => $newVal) {
            $oldVal = $this->old_values[$key] ?? null;
            if ((string) $oldVal !== (string) $newVal) {
                $changed[$key] = ['old' => $oldVal, 'new' => $newVal];
            }
        }
        return $changed;
    }
}
