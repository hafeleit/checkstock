<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PermissionUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $status;
    public $permissionId;
    public $oldPermissionName;
    public $newPermissionName;
    public $errorMessage;
    /**
     * Create a new event instance.
     */
    public function __construct($userId, $status, $permissionId, $oldPermissionName, $newPermissionName, $errorMessage = null)
    {
        $this->userId = $userId;
        $this->status = $status;
        $this->permissionId = $permissionId;
        $this->oldPermissionName = $oldPermissionName;
        $this->newPermissionName = $newPermissionName;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
