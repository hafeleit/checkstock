<?php

namespace App\Listeners;

use App\Events\CommissionPasswordVerified;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCommissionPasswordVerify
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
    public function handle(CommissionPasswordVerified $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'commission_verified',
            'status' => $event->status,
            'auditable_type' => 'App\Models\Commission',
            'auditable_id' => $event->userId,
            'error_message' => $event->errorMessage,
        ]);
    }
}
