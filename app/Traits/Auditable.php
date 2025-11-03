<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            self::audit('created', $model);
        });
        static::updated(function ($model) {
            self::audit('updated', $model);
        });
        static::deleted(function ($model) {
            self::audit('deleted', $model);
        });
    }

    protected static function audit(string $event, $model)
    {
        // กำหนดค่า new_values ตามประเภทของ event
        $newValues = null;
        if ($event === 'created') {
            $newValues = json_encode($model->getAttributes());
        } elseif ($event === 'updated') {
            $newValues = json_encode($model->getChanges());
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'status' => 'pass',
            'old_values' => ($event === 'updated') ? json_encode($model->getOriginal()) : null,
            'new_values' => $newValues,
        ]);
    }
}
