<?php
// File: backend/app/Http/Controllers/API/Admin/SubscriptionPlanController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return response()->json(SubscriptionPlan::all());
    }

    public function store(Request $r)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $plan = SubscriptionPlan::create($r->only('name','config'));
        return response()->json($plan,201);
    }

    public function update(Request $r, SubscriptionPlan $subscriptionPlan)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $subscriptionPlan->update($r->only('name','config'));
        return response()->json($subscriptionPlan);
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();
        return response()->json(null,204);
    }
}
