<?php
// File: app/Events/UserOrderFilled.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOrderFilled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $order;

    public function __construct(int $userId, array $order)
    {
        $this->userId = $userId;
        $this->order  = $order;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->userId}");
    }

    public function broadcastWith()
    {
        return ['order' => $this->order];
    }
}
