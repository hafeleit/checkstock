<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommissionStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $commissionId;
    public $status;
    public $oldStatus;
    public $newStatus;
    public $salesReps;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $commissionId, $status, $oldStatus, $newStatus, $salesReps = [], $errorMessage = null)
    {
        $this->userId = $userId;
        $this->commissionId = $commissionId;
        $this->status = $status;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->salesReps = $salesReps;
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
