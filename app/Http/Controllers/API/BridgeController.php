<?php
// File: backend/app/Http/Controllers/API/ChainlinkController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ChainlinkController extends Controller
{
    /**
     * GET /api/v1/chainlink/feeds
     * Returns the symbol=>aggregatorAddress map.
     */
    public function feeds()
    {
        return response()->json(config('services.chainlink.feeds'));
    }
}
