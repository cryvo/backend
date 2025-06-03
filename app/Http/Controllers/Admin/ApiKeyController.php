<?php
// app/Http/Controllers/Admin/ApiKeyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->apiKeys;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $key = Str::random(40);
        $apiKey = ApiKey::create([
            'user_id' => $request->user()->id,
            'name'    => $data['name'],
            'key'     => $key,
        ]);

        return response()->json($apiKey, 201);
    }

    public function destroy(ApiKey $apiKey)
    {
        $apiKey->update(['revoked_at'=>now()]);
        return response()->noContent();
    }
}
