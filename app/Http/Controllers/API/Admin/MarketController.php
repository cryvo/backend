<?php
// File: backend/app/Http/Controllers/API/Admin/MarketController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        return response()->json(Market::orderBy('symbol')->get());
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'   => 'required|string',
            'symbol' => 'required|string|unique:markets,symbol',
            'config' => 'nullable|array',
        ]);
        $m = Market::create($r->only('name','symbol','config'));
        return response()->json($m, 201);
    }

    public function update(Request $r, Market $market)
    {
        $r->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);
        $market->update($r->only('name','config'));
        return response()->json($market);
    }

    public function destroy(Market $market)
    {
        $market->delete();
        return response()->json(null, 204);
    }
}
