<?php

namespace App\Listeners;

use App\Events\PermissionUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPermissionUpdate
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
    public function handle(PermissionUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'updated',
            'status' => $event->status,
            'auditable_type' => 'Spatie\Permission\Models\Permission',
            'auditable_id' => $event->permissionId,
            'old_values' => json_encode(['name' => $event->oldPermissionName]),
            'new_values' => json_encode(['name' => $event->newPermissionName]),
            'error_message' => $event->errorMessage,
        ]);
    }
}
