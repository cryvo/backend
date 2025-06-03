<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\StocksService;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    protected StocksService $stocks;

    public function __construct(StocksService $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * GET /api/v1/stocks/data?symbol=MSFT
     */
    public function data(Request $r)
    {
        $r->validate(['symbol'=>'required|string']);
        $data = $this->stocks->getStockData($r->symbol);
        return response()->json($data);
    }
}
