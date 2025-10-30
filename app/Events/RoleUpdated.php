<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $status;
    public $roleId;
    public $oldRoleName;
    public $newRoleName;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $status, $roleId, $oldRoleName, $newRoleName, $errorMessage = null)
    {
        $this->userId = $userId;
        $this->status = $status;
        $this->roleId = $roleId;
        $this->oldRoleName = $oldRoleName;
        $this->newRoleName = $newRoleName;
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
