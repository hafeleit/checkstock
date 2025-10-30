<?php

namespace App\Listeners;

use App\Events\FileImported;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFileImport
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
    public function handle(FileImported $event): void
    {
        AuditLog::create([
            'user_id' => $event->user_id,
            'event' => $event->event,
            'status' => $event->status,
            'auditable_type' => $event->model,
            'file_name' => $event->file_name,
            'file_size' => $event->file_size,
            'error_message' => $event->error_message,
        ]);
    }
}
