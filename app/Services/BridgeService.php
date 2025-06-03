<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BridgeService;

class BridgeController extends Controller
{
    protected BridgeService $bridge;

    public function __construct(BridgeService $bridge)
    {
        $this->bridge = $bridge;
    }

    /**
     * GET /api/v1/defi/bridge/quote
     * Query Params: fromChain, toChain, fromToken, toToken, amount
     */
    public function quote(Request $r)
    {
        $v = $r->validate([
            'fromChain' => 'required|numeric',
            'toChain'   => 'required|numeric',
            'fromToken' => 'required|string',
            'toToken'   => 'required|string',
            'amount'    => 'required|string', // smallest unit
        ]);

        $quote = $this->bridge->getQuote(
            $v['fromChain'],
            $v['toChain'],
            $v['fromToken'],
            $v['toToken'],
            $v['amount']
        );

        return response()->json($quote);
    }
}
