<?php

namespace App\Listeners;

use App\Events\RoleCreated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRoleCreation
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
    public function handle(RoleCreated $event): void
    {
        if ($event->roleId) {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'Spatie\Role\Models\Role',
                'auditable_id' => $event->roleId,
                'new_values' => json_encode(['name' => $event->roleName]),
                'error_message' => $event->errorMessage,
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'Spatie\Role\Models\Role',
                'new_values' => json_encode(['name' => $event->roleName]),
                'error_message' => $event->errorMessage,
            ]);
        }
    }
}
