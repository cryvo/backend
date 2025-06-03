<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotSetting;

class BotSettingController extends Controller
{
    public function index()
    {
        return response()->json(BotSetting::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $setting = BotSetting::create($data);
        return response()->json($setting, 201);
    }

    public function show(BotSetting $botSetting)
    {
        return response()->json($botSetting);
    }

    public function update(Request $request, BotSetting $botSetting)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $botSetting->update($data);
        return response()->json($botSetting);
    }

    public function destroy(BotSetting $botSetting)
    {
        $botSetting->delete();
        return response()->json(null, 204);
    }
}
