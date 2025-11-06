<?php

namespace App\Listeners;

use App\Events\CommissionAdjusted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionAdjust
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
    public function handle(CommissionAdjusted $event): void
    {
        if ($event->status == 'pass') {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'adjust',
                'status' => $event->status,
                'auditable_type' => 'App\Models\CommissionsAR',
                'auditable_id' => $event->commission->id,
                'new_values' => json_encode($event->commission),
            ]);
        } else {
            AuditLog::create([
                'user_id' => $event->userId,
                'event' => 'adjust',
                'status' => $event->status,
                'auditable_type' => 'App\Models\CommissionsAR',
                'new_values' => json_encode($event->commission),
            ]);
        }
    }
}
