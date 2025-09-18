<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PermissionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $permissionId;
    public $status;
    public $permissionName;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $permissionId, $status, $permissionName, $errorMessage = null)
    {
        $this->userId = $userId;
        $this->permissionId = $permissionId;
        $this->status = $status;
        $this->permissionName = $permissionName;
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
