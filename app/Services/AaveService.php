<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AaveService;

class DefiController extends Controller
{
    protected AaveService $aave;

    public function __construct(AaveService $aave)
    {
        $this->aave = $aave;
    }

    /**
     * GET /api/v1/defi/staking/apy?symbol=aWETH
     */
    public function stakingApy(Request $r)
    {
        $v = $r->validate(['symbol'=>'required|string']);
        $apy = $this->aave->getApy($v['symbol']);
        return response()->json(['symbol'=>$v['symbol'],'apy'=>$apy]);
    }
}
