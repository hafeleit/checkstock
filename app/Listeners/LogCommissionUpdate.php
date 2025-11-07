<?php

namespace App\Listeners;

use App\Events\CommissionUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionUpdate
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
    public function handle(CommissionUpdated $event): void
    {
        if ($event->status == 'pass') {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'updated',
                'status' => $event->status,
                'auditable_type' => $event->model,
                'auditable_id' => $event->newCommission->id,
                'new_values' => json_encode($event->newCommission),
                'old_values' => json_encode($event->oldCommission),
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'updated',
                'status' => $event->status,
                'auditable_type' => $event->model,
                'auditable_id' => $event->newCommission->id,
                'new_values' => json_encode($event->newCommission),
                'old_values' => json_encode($event->oldCommission),
                'error_message' => $event->errorMessage
            ]);
        }
    }
}
