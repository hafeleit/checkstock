<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileImported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $event;
    public $model;
    public $status;
    public $file_name;
    public $file_size;
    public $error_message;

    /**
     * Create a new event instance.
     */
    public function __construct($model, $user_id, $event, $status, $file_name, $file_size = null, $error_message = null)
    {
        $this->model = $model;
        $this->user_id = $user_id;
        $this->event = $event;
        $this->status = $status;
        $this->file_name = $file_name;
        $this->file_size = $file_size;
        $this->error_message = $error_message;
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
