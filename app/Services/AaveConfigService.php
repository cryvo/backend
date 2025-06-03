<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AaveUserService;
use App\Services\AaveConfigService;
use Illuminate\Support\Facades\Auth;

class DefiUserController extends Controller
{
    protected AaveUserService  $userSvc;
    protected AaveConfigService $cfgSvc;

    public function __construct(
        AaveUserService $userSvc,
        AaveConfigService $cfgSvc
    ) {
        $this->userSvc = $userSvc;
        $this->cfgSvc  = $cfgSvc;
    }

    /**
     * GET /api/v1/defi/aave/positions
     * Returns the authenticated user’s Aave positions.
     */
    public function positions(Request $r)
    {
        $user = Auth::user();
        // user must supply their wallet address in profile
        $addr = $user->wallet_address; 
        $positions = $this->userSvc->getUserReserves($addr);
        return response()->json($positions);
    }

    /**
     * GET /api/v1/defi/aave/config?symbol=aWETH
     * Returns contract addresses for a given aToken.
     */
    public function config(Request $r)
    {
        $v = $r->validate(['symbol'=>'required|string']);
        $cfg = $this->cfgSvc->getConfig($v['symbol']);
        return response()->json($cfg);
    }
}
