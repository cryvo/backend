<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MatchingEngineService;

class SpotController extends Controller
{
    protected MatchingEngineService $engine;

    public function __construct(MatchingEngineService $engine)
    {
        $this->engine = $engine;
    }

    // GET /api/v1/spot/orderbook?symbol=BTC_USDT
    public function orderbook(Request $r)
    {
        $symbol = $r->query('symbol');
        $book   = $this->engine->getOrderBook($symbol);
        return response()->json($book);
    }

    // POST /api/v1/spot/order
    public function order(Request $r)
    {
        $data = $r->validate([
            'symbol' => 'required|string',
            'side'   => 'required|in:buy,sell',
            'price'  => 'required|numeric',
            'amount' => 'required|numeric',
            'type'   => 'required|in:limit,market',
        ]);

        $order = $this->engine->placeOrder($data);
        return response()->json($order);
    }
}
