<?php

namespace App\Listeners;

use App\Events\CommissionDeleted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionDelete
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
    public function handle(CommissionDeleted $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'deleted',
            'status' => $event->status,
            'auditable_type' => 'App\Models\Commission',
            'auditable_id' => $event->commissionId,
            'error_message' => $event->errorMessage,
        ]);
    }
}
