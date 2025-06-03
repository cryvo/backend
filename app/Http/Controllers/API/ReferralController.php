<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * GET /api/v1/admin/settings/analytics-metrics
     */
    public function index()
    {
        $dailyVolume = Trade::whereDate('created_at', now())->sum('volume');
        $activeUsers = User::where('last_login_at', '>=', now()->subDay())->count();
        $subs        = Subscription::whereDate('created_at', now())->count();
        $history     = Trade::selectRaw('DATE(created_at) as date, SUM(volume) as volume')
                             ->where('created_at', '>=', now()->subDays(30))
                             ->groupBy('date')->get();

        return response()->json([
            'dailyVolume'        => $dailyVolume,
            'activeUsers'        => $activeUsers,
            'crybotSubscriptions'=> $subs,
            'volumeHistory'      => $history->map(fn($h)=>[
                                      'date'   => $h->date,
                                      'volume' => (float)$h->volume,
                                    ]),
        ]);
    }
}
