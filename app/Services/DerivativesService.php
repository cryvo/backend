<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DerivativesService;
use Illuminate\Http\Request;

class DerivativesController extends Controller
{
    protected DerivativesService $deriv;

    public function __construct(DerivativesService $deriv)
    {
        $this->deriv = $deriv;
    }

    /**
     * GET /api/v1/futures/orderbook?market=BTC-USD
     */
    public function orderbook(Request $r)
    {
        $r->validate(['market'=>'required|string']);
        $data = $this->deriv->getOrderBook($r->market);
        return response()->json($data);
    }

    /**
     * GET /api/v1/futures/stats?market=BTC-USD
     */
    public function stats(Request $r)
    {
        $r->validate(['market'=>'required|string']);
        $data = $this->deriv->getMarketStats($r->market);
        return response()->json($data);
    }
}
