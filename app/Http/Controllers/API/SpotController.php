<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MatchingEngineService;

class FuturesController extends Controller
{
    protected MatchingEngineService $engine;

    public function __construct(MatchingEngineService $engine)
    {
        $this->engine = $engine;
    }

    // GET /api/v1/futures/orderbook?symbol=BTCUSDT
    public function orderbook(Request $r)
    {
        $symbol = $r->query('symbol');
        $book   = $this->engine->getOrderBook($symbol);
        return response()->json($book);
    }

    // POST /api/v1/futures/order
    public function order(Request $r)
    {
        $data = $r->validate([
            'symbol'   => 'required|string',
            'side'     => 'required|in:buy,sell',
            'price'    => 'required|numeric',
            'quantity' => 'required|numeric',
            'leverage' => 'required|integer|min:1',
            'type'     => 'required|in:limit,market',
        ]);

        // adapt field names if needed
        $order = $this->engine->placeOrder([
            'symbol' => $data['symbol'],
            'side'   => $data['side'],
            'price'  => $data['price'],
            'amount' => $data['quantity'],
            'type'   => $data['type'],
        ]);

        return response()->json($order);
    }
}
