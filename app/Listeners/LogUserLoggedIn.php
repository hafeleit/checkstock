<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLoggedIn
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
    public function handle(UserLoggedIn $event): void
    {
        if (!$event->user_id) {
            AuditLog::create([
                'event' => $event->event,
                'status' => $event->status,
                'auditable_type' => 'App\Models\User',
                'new_values' => json_encode(['ip_address' => request()->ip()]),
                'error_message' => $event->error_message,
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->user_id,
                'event' => $event->event,
                'status' => $event->status,
                'auditable_type' => 'App\Models\User',
                'auditable_id' => $event->user_id,
                'new_values' => json_encode(['ip_address' => request()->ip()]),
                'error_message' => $event->error_message,
            ]);
        }
    }
}
