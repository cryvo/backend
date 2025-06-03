<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;

class FeeController extends Controller
{
    public function index()
    {
        return response()->json(Fee::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $fee = Fee::create($data);
        return response()->json($fee, 201);
    }

    public function show(Fee $fee)
    {
        return response()->json($fee);
    }

    public function update(Request $request, Fee $fee)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $fee->update($data);
        return response()->json($fee);
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return response()->json(null, 204);
    }
}
