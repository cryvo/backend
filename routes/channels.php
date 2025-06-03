<?php

use Illuminate\Support\Facades\Broadcast;

/*
 * Public orderbook streams for each market:
 *   broadcast to channel “orderbook.{symbol}”
 */
Broadcast::channel('orderbook.{symbol}', function ($user, $symbol) {
    return true; // public data
});

/*
 * Private user channel for their order‐fills & balances:
 *   “user.{id}”
 */
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
