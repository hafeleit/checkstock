<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserUpdate
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
    public function handle(UserUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'updated',
            'status' => $event->status,
            'auditable_type' => 'App\Models\User',
            'auditable_id' => $event->userCreatedId,
            'new_values' => json_encode($event->newValues),
            'old_values' => json_encode($event->oldValues),
            'error_message' => $event->errorMessage,
        ]);
    }
}
