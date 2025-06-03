<?php
// File: backend/app/Http/Controllers/API/CompoundController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompoundService;
use App\Services\CompoundConfigService;
use Illuminate\Support\Facades\Auth;

class CompoundController extends Controller
{
    protected CompoundService $svc;
    protected CompoundConfigService $cfg;

    public function __construct(
        CompoundService $svc,
        CompoundConfigService $cfg
    ) {
        $this->svc = $svc;
        $this->cfg = $cfg;
    }

    /**
     * GET /api/v1/defi/compound/positions
     */
    public function positions(Request $r)
    {
        $addr = Auth::user()->wallet_address;
        $pos  = $this->svc->getUserPositions($addr);
        return response()->json($pos);
    }

    /**
     * GET /api/v1/defi/compound/config?symbol=cDAI
     */
    public function config(Request $r)
    {
        $v = $r->validate(['symbol'=>'required|string']);
        $cfg = $this->cfg->getConfig($v['symbol']);
        if (! $cfg) {
            return response()->json(['error'=>'Unknown market'], 404);
        }
        // include Comptroller or ABI endpoints as needed
        return response()->json($cfg);
    }
}
