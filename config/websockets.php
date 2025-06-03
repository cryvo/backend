<?php
// File: app/Events/OrderBookUpdated.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderBookUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $symbol;
    public $bids;
    public $asks;

    public function __construct(string $symbol, array $bids, array $asks)
    {
        $this->symbol = $symbol;
        $this->bids   = $bids;
        $this->asks   = $asks;
    }

    public function broadcastOn()
    {
        return new Channel("orderbook.{$this->symbol}");
    }

    public function broadcastWith()
    {
        return [
          'bids' => $this->bids,
          'asks' => $this->asks,
        ];
    }
}
