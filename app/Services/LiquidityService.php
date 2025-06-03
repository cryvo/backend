<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LiquidityService;

class LiquidityController extends Controller
{
    protected LiquidityService $liq;

    public function __construct(LiquidityService $liq)
    {
        $this->liq = $liq;
    }

    /**
     * GET /api/v1/liquidity/orderbook?symbol=BTC_USDT
     */
    public function orderbook(Request $r)
    {
        $symbol = $r->query('symbol');
        if (! $symbol) {
            return response()->json(['error'=>'symbol query required'], 422);
        }
        $book = $this->liq->getAggregatedOrderBook($symbol);
        return response()->json($book);
    }
}
