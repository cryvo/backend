<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderRouterService;

class OrderRouterController extends Controller
{
    protected OrderRouterService $router;

    public function __construct(OrderRouterService $router)
    {
        $this->router = $router;
    }

    /**
     * POST /api/v1/order/smart
     * Body: { symbol, side, amount }
     */
    public function execute(Request $r)
    {
        $data = $r->validate([
            'symbol' => 'required|string',
            'side'   => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.0001',
        ]);

        try {
            $resp = $this->router->routeOrder($data);
            return response()->json(['success'=>true,'order'=>$resp]);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ], 500);
        }
    }
}
