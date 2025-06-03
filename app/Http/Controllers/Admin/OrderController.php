<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('user')->orderBy('created_at','desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pair'    => 'required|string',
            'type'    => 'required|in:buy,sell',
            'amount'  => 'required|numeric',
            'price'   => 'required|numeric',
            'status'  => 'required|in:open,partially_filled,filled,cancelled',
        ]);

        return Order::create($data);
    }

    public function show(Order $order)
    {
        return $order->load('user');
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:open,partially_filled,filled,cancelled',
        ]);

        $order->update($data);
        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
