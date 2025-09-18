<?php

namespace App\Listeners;

use App\Events\PermissionCreated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPermissionCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PermissionCreated $event): void
    {
        if ($event->permissionId) {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'Spatie\Permission\Models\Permission',
                'auditable_id' => $event->permissionId,
                'new_values' => json_encode(['name' => $event->permissionName]),
                'error_message' => $event->errorMessage,
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'Spatie\Permission\Models\Permission',
                'new_values' => json_encode(['name' => $event->permissionName]),
                'error_message' => $event->errorMessage,
            ]);
        }
    }
}
