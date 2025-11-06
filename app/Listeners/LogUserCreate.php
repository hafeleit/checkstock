<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserCreate
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
    public function handle(UserCreated $event): void
    {
        if ($event->status == 'pass') {
            AuditLog::create([
                'user_id' => $event->user,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'App\Models\User',
                'auditable_id' => $event->data->id,
                'new_values' => json_encode($event->data),
                'error_message' => $event->errorMessage,
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->user,
                'event' => 'created',
                'status' => $event->status,
                'auditable_type' => 'App\Models\User',
                'new_values' => json_encode($event->data),
                'error_message' => $event->errorMessage,
            ]);
        }
    }
}
