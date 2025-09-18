<?php

namespace App\Listeners;

use App\Events\RolePermissionsUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRolePermissionsUpdate
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
    public function handle(RolePermissionsUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'role_permissions_updated',
            'status' => $event->status,
            'auditable_type' => 'Spatie\Permission\Models\Role',
            'auditable_id' => $event->roleId,
            'old_values' => json_encode($event->oldPermissions),
            'new_values' => json_encode($event->newPermissions),
            'error_message' => $event->errorMessage,
        ]);
    }
}
