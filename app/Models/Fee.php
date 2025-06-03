<?php
// File: backend/app/Http/Controllers/API/Admin/FeeController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        return response()->json(Fee::orderBy('name')->get());
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);
        $fee = Fee::create($r->only('name','config'));
        return response()->json($fee, 201);
    }

    public function update(Request $r, Fee $fee)
    {
        $r->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);
        $fee->update($r->only('name','config'));
        return response()->json($fee);
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return response()->json(null, 204);
    }
}
