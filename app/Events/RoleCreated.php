<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $roleId;
    public $status;
    public $roleName;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $roleId, $status, $roleName, $errorMessage = null)
    {
        $this->userId = $userId;
        $this->roleId = $roleId;
        $this->status = $status;
        $this->roleName = $roleName;
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
