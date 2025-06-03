<?php
// app/Http/Controllers/Admin/KycController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kyc;

class KycController extends Controller
{
    public function index()
    {
        return Kyc::with('user')->orderBy('submitted_at','desc')->get();
    }

    public function show(Kyc $kyc)
    {
        return $kyc->load('user');
    }

    public function update(Request $request, Kyc $kyc)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $kyc->update($data);
        return $kyc;
    }
}
