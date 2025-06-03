<?php
// app/Http/Controllers/Admin/ReferralController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;

class ReferralController extends Controller
{
    public function index()
    {
        return Referral::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'code'        => 'required|string|unique:referrals',
            'reward_points'=>'required|integer',
        ]);

        return Referral::create($data);
    }
}
