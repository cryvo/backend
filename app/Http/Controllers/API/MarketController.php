<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\P2POffer;
use Illuminate\Http\Request;

class P2POfferController extends Controller
{
    /**
     * GET /api/v1/p2p/offers
     */
    public function index()
    {
        return response()->json(
            P2POffer::where('is_active', true)
                ->get(['id','advertiser','side','currency','price','min_limit','max_limit','available','payment_methods'])
        );
    }
}
