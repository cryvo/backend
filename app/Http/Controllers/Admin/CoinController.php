<?php
// app/Http/Controllers/Admin/CoinController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    public function index()
    {
        return Coin::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'symbol' => 'required|string|unique:coins',
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        return Coin::create($data);
    }

    public function show(Coin $coin)
    {
        return $coin;
    }

    public function update(Request $request, Coin $coin)
    {
        $data = $request->validate([
            'symbol' => "required|string|unique:coins,symbol,{$coin->id}",
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $coin->update($data);
        return $coin;
    }

    public function destroy(Coin $coin)
    {
        $coin->delete();
        return response()->noContent();
    }
}
