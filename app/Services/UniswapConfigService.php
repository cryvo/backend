<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UniswapService;
use App\Services\UniswapConfigService;
use Illuminate\Support\Facades\Auth;

class UniswapController extends Controller
{
    protected UniswapService       $svc;
    protected UniswapConfigService $cfg;

    public function __construct(
        UniswapService $svc,
        UniswapConfigService $cfg
    ) {
        $this->svc = $svc;
        $this->cfg = $cfg;
    }

    /**
     * GET /api/v1/defi/uniswap/positions
     */
    public function positions()
    {
        $addr = Auth::user()->wallet_address;
        $pos  = $this->svc->getUserPositions($addr);
        return response()->json($pos);
    }

    /**
     * GET /api/v1/defi/uniswap/config
     */
    public function config()
    {
        return response()->json($this->cfg->getConfig());
    }
}
