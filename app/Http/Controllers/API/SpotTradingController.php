<?php
// backend/app/Http/Controllers/API/SpotTradingController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Trade;
use App\Services\MatchingEngine; // your matching engine service

class SpotTradingController extends Controller
{
    public function orderBook($pair)
    {
        $bids = Order::bids($pair)->get();
        $asks = Order::asks($pair)->get();
        return response()->json(compact('bids','asks'));
    }

    public function placeOrder(Request $req)
    {
        $order = MatchingEngine::place($req->user(), $req->pair, $req->type, $req->price, $req->amount);
        return response()->json($order, 201);
    }

    public function cancelOrder($id)
    {
        MatchingEngine::cancel(auth()->user(), $id);
        return response()->json(['message'=>'Canceled']);
    }

    public function myOrders()
    {
        return response()->json(auth()->user()->orders()->latest()->get());
    }
}
