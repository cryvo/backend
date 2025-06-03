<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;

class ReferralController extends Controller
{
    /**
     * GET /api/v1/user/referrals
     */
    public function index()
    {
        $user = Auth::user();
        $link = url("/register?ref={$user->uid}");
        $stats = Referral::where('referrer_id', $user->id)->count();
        $rewards = Referral::where('referrer_id', $user->id)->sum('reward_amount');
        return response()->json([
            'link'      => $link,
            'referrals' => $stats,
            'rewards'   => $rewards,
        ]);
    }
}
