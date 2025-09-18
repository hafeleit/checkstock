<?php

namespace App\Listeners;

use App\Events\OrderSync;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogOrderSync
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
    public function handle(OrderSync $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'order_sync',
            'status' => $event->status,
            'error_message' => ($event->status === 'fail') ? $event->message : null,
            'new_values' => json_encode([
                'new_order_count' => $event->newOrderCount,
                'message' => $event->message,
            ]),
            'file_name' => $event->fileName,
        ]);
    }
}
