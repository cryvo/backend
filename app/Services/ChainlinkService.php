<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ChainlinkService;
use Illuminate\Http\Request;

class ChainlinkController extends Controller
{
    protected ChainlinkService $chainlink;

    public function __construct(ChainlinkService $chainlink)
    {
        $this->chainlink = $chainlink;
    }

    /**
     * GET /api/v1/chainlink/price?symbol=BTC_USD
     */
    public function price(Request $r)
    {
        $r->validate(['symbol'=>'required|string']);
        return response()->json($this->chainlink->getLatestPrice($r->symbol));
    }

    /**
     * GET /api/v1/chainlink/prices
     */
    public function prices()
    {
        return response()->json($this->chainlink->listPrices());
    }
}
