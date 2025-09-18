<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;
    public $userId;
    public $status;
    public $recordId;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($model, $userId, $status, $recordId, $errorMessage = null)
    {
        $this->model = $model;
        $this->userId = $userId;
        $this->status = $status;
        $this->recordId = $recordId;
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
