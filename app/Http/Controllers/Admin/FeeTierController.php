<?php
// app/Http/Controllers/Admin/FeeTierController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeTier;

class FeeTierController extends Controller
{
    public function index()
    {
        return FeeTier::orderBy('min_volume_usd')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'min_volume_usd' => 'required|numeric',
            'maker_fee'      => 'required|numeric',
            'taker_fee'      => 'required|numeric',
        ]);

        return FeeTier::create($data);
    }

    public function show(FeeTier $feeTier)
    {
        return $feeTier;
    }

    public function update(Request $request, FeeTier $feeTier)
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'min_volume_usd' => 'required|numeric',
            'maker_fee'      => 'required|numeric',
            'taker_fee'      => 'required|numeric',
        ]);

        $feeTier->update($data);
        return $feeTier;
    }

    public function destroy(FeeTier $feeTier)
    {
        $feeTier->delete();
        return response()->noContent();
    }
}
