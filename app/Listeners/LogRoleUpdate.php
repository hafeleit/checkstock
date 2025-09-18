<?php

namespace App\Listeners;

use App\Events\RoleUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRoleUpdate
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
    public function handle(RoleUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'updated',
            'status' => $event->status,
            'auditable_type' => 'Spatie\Role\Models\Role',
            'auditable_id' => $event->roleId,
            'old_values' => json_encode(['name' => $event->oldRoleName]),
            'new_values' => json_encode(['name' => $event->newRoleName]),
            'error_message' => $event->errorMessage,
        ]);
    }
}
