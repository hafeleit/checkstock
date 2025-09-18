<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderSync
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userId;
    public $status;
    public $message;
    public $newOrderCount;
    public $fileName;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $status, $message, $newOrderCount = 0, $fileName = null)
    {
        $this->userId = $userId;
        $this->status = $status;
        $this->message = $message;
        $this->newOrderCount = $newOrderCount;
        $this->fileName = $fileName;
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
