<?php

namespace App\Listeners;

use App\Events\WarrantyCreated;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogWarrantyCreation
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
    public function handle(WarrantyCreated $event): void
    {
        AuditLog::create([
            'event' => 'created',
            'auditable_type' => 'App\Models\Warranty',
            'status' => $event->status,
            'new_values' => json_encode($event->warrantyData),
            'file_name' => json_encode($event->fileNames),
            'error_message' => $event->errorMessage,
        ]);
    }
}
