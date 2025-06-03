<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    // GET /api/v1/admin/coins
    public function index()
    {
        return response()->json(Coin::orderBy('symbol')->get());
    }

    // POST /api/v1/admin/coins
    public function store(Request $r)
    {
        $r->validate([
            'name'   => 'required|string',
            'symbol' => 'required|string|unique:coins,symbol',
            'config' => 'nullable|array',
        ]);
        $coin = Coin::create($r->only('name','symbol','config'));
        return response()->json($coin, 201);
    }

    // PUT /api/v1/admin/coins/{coin}
    public function update(Request $r, Coin $coin)
    {
        $r->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);
        $coin->update($r->only('name','config'));
        return response()->json($coin);
    }

    // DELETE /api/v1/admin/coins/{coin}
    public function destroy(Coin $coin)
    {
        $coin->delete();
        return response()->json(null, 204);
    }
}
