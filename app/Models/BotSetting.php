<?php
// File: backend/app/Http/Controllers/API/Admin/BotSettingController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotSetting;
use Illuminate\Http\Request;

class BotSettingController extends Controller
{
    public function index()
    {
        return response()->json(BotSetting::all());
    }

    public function store(Request $r)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $b = BotSetting::create($r->only('name','config'));
        return response()->json($b,201);
    }

    public function update(Request $r, BotSetting $botSetting)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $botSetting->update($r->only('name','config'));
        return response()->json($botSetting);
    }

    public function destroy(BotSetting $botSetting)
    {
        $botSetting->delete();
        return response()->json(null,204);
    }
}
