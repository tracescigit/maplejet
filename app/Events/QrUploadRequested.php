<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QrUploadRequested
{
    use Dispatchable, SerializesModels;

    public $quantity;
    public $baseUrl;

    /**
     * Create a new event instance.
     *
     * @param int $quantity
     * @param string $baseUrl
     * @return void
     */
    public function __construct($quantity, $baseUrl)
    {
        $this->quantity = $quantity;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
