<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * GET /api/v1/admin/analytics/risk
     */
    public function risk()
    {
        $userId = Auth::id();
        return response()->json($this->analytics->getRiskScore($userId));
    }

    /**
     * GET /api/v1/analytics/fraud?tx_id=...
     */
    public function fraud(Request $r)
    {
        $r->validate(['tx_id'=>'required|string']);
        return response()->json(
            $this->analytics->detectFraud($r->tx_id)
        );
    }

    /**
     * GET /api/v1/analytics/signals
     */
    public function signals()
    {
        $userId = Auth::id();
        return response()->json($this->analytics->getSignals($userId));
    }
}
