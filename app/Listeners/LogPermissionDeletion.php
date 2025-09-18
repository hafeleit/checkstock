<?php

namespace App\Listeners;

use App\Events\PermissionDeleted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPermissionDeletion
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
    public function handle(PermissionDeleted $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'deleted',
            'status' => $event->status,
            'auditable_type' => 'Spatie\Permission\Models\Permission',
            'auditable_id' => $event->permissionId,
            'old_values' => json_encode(['name' => $event->permissionName]),
            'error_message' => $event->errorMessage,
        ]);
    }
}
