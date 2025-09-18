<?php

namespace App\Listeners;

use App\Events\RecordDeleted;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRecordDeletion
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
    public function handle(RecordDeleted $event): void
    {
        AuditLog::create([
            'user_id' => $event->userId,
            'event' => 'deleted',
            'status' => $event->status,
            'auditable_type' => $event->model,
            'auditable_id' => $event->recordId,
            'error_message' => $event->errorMessage,
        ]);
    }
}
