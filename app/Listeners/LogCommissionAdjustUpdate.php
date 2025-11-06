<?php

namespace App\Listeners;

use App\Events\CommissionAdjustUpdated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionAdjustUpdate
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
    public function handle(CommissionAdjustUpdated $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'adjust_updated',
            'status' => $event->status,
            'auditable_type' => 'App\Models\CommissionsAR',
            'auditable_id' => $event->newCommission->id,
            'new_values' => json_encode($event->newCommission),
            'old_values' => json_encode($event->oldCommission),
            'error_message' => $event->errorMessage,
        ]);
    }
}
