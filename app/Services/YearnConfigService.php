<?php
// File: backend/app/Http/Controllers/API/YearnController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\YearnService;
use App\Services\YearnConfigService;
use Illuminate\Support\Facades\Auth;

class YearnController extends Controller
{
    protected YearnService $svc;
    protected YearnConfigService $cfg;

    public function __construct(YearnService $svc, YearnConfigService $cfg)
    {
        $this->svc = $svc;
        $this->cfg = $cfg;
    }

    /**
     * GET /api/v1/defi/yearn/positions
     */
    public function positions(Request $r)
    {
        $addr = Auth::user()->wallet_address;
        return response()->json($this->svc->getUserVaults($addr));
    }

    /**
     * GET /api/v1/defi/yearn/config?symbol=yvDAI
     */
    public function config(Request $r)
    {
        $v = $r->validate(['symbol'=>'required|string']);
        $c = $this->cfg->getConfig($v['symbol']);
        return $c ? response()->json($c) : response()->json(['error'=>'Unknown vault'],404);
    }
}
