<?php
// app/Http/Controllers/Admin/TradeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trade;

class TradeController extends Controller
{
    public function index()
    {
        return Trade::orderBy('created_at','desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buy_order_id'  => 'required|exists:orders,id',
            'sell_order_id' => 'required|exists:orders,id',
            'pair'          => 'required|string',
            'price'         => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        return Trade::create($data);
    }

    public function show(Trade $trade)
    {
        return $trade;
    }

    public function update(Request $request, Trade $trade)
    {
        $data = $request->validate([
            'price'  => 'sometimes|numeric',
            'amount' => 'sometimes|numeric',
        ]);

        $trade->update($data);
        return $trade;
    }

    public function destroy(Trade $trade)
    {
        $trade->delete();
        return response()->noContent();
    }
}
