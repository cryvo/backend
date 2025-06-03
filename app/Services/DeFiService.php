<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DeFiService;

class DeFiController extends Controller
{
    protected DeFiService $defi;
    public function __construct(DeFiService $defi) { $this->defi = $defi; }

    /**
     * GET /api/v1/defi/aave
     */
    public function aave()
    {
        return response()->json($this->defi->getAaveRates());
    }

    /**
     * GET /api/v1/defi/compound
     */
    public function compound()
    {
        return response()->json($this->defi->getCompoundRates());
    }
}
