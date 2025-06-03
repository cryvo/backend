<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    public function index()
    {
        return response()->json(Coin::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $coin = Coin::create($data);
        return response()->json($coin, 201);
    }

    public function show(Coin $coin)
    {
        return response()->json($coin);
    }

    public function update(Request $request, Coin $coin)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $coin->update($data);
        return response()->json($coin);
    }

    public function destroy(Coin $coin)
    {
        $coin->delete();
        return response()->json(null, 204);
    }
}
