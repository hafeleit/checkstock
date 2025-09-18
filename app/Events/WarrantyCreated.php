<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WarrantyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $warrantyData;
    public $fileNames;
    public $errorMessage;

    /**
     * Create a new event instance.
     */
    public function __construct($status, $warrantyData, $fileNames, $errorMessage = null)
    {
        $this->status = $status;
        $this->warrantyData = $warrantyData;
        $this->fileNames = $fileNames;
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
