<?php

namespace App\Listeners;

use App\Events\CommissionStatusUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionStatusUpdate
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
    public function handle(CommissionStatusUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'status_updated',
            'status' => $event->status,
            'auditable_type' => 'App\Models\Commission',
            'auditable_id' => $event->commissionId,
            'old_values' => json_encode(['status' => $event->oldStatus]),
            'new_values' => json_encode([
                'status' => $event->newStatus,
                'selected_sales' => $event->salesReps
            ]),
            'error_message' => $event->errorMessage
        ]);
    }
}
