<?php

namespace App\Listeners;

use App\Events\RoleDeleted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRoleDelete
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
    public function handle(RoleDeleted $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'deleted',
            'status' => $event->status,
            'auditable_type' => 'Spatie\Role\Models\Role',
            'auditable_id' => $event->roleId,
            'old_values' => json_encode(['name' => $event->roleName]),
            'error_message' => $event->errorMessage,
        ]);
    }
}
