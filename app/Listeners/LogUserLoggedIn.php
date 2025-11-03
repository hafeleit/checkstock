<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLoggedIn
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
    public function handle(UserLoggedIn $event)
    {
        $ipAddress = request()->ip();
        $userAgent = request()->header('User-Agent');
        $deviceType = 'Desktop';

        if (preg_match('/(android|iphone|ipad|mobile|tablet)/i', $userAgent)) {
            $deviceType = 'Mobile/Tablet';
        }

        $newValues = json_encode([
            'ip_address' => $ipAddress,
            'device_type' => $deviceType,
        ]);

        $logData = [
            'event' => $event->event,
            'status' => $event->status,
            'auditable_type' => 'App\Models\User',
            'new_values' => $newValues,
            'error_message' => $event->error_message,
        ];

        if ($event->user_id) {
            $logData['user_id'] = $event->user_id;
            $logData['auditable_id'] = $event->user_id;
        }

        AuditLog::create($logData);
    }
}
