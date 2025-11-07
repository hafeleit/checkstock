<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommissionUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $model;
    public $oldCommission;
    public $newCommission;
    public $status;
    public $errorMessage;


    /**
     * Create a new event instance.
     */
    public function __construct($userId, $model, $oldCommission, $newCommission, $status, $errorMessage = null)
    {
        $this->userId = $userId;
        $this->model = $model;
        $this->newCommission = $newCommission;
        $this->oldCommission = $oldCommission;
        $this->status = $status;
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
