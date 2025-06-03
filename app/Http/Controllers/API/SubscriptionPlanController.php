<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return response()->json(SubscriptionPlan::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $plan = SubscriptionPlan::create($data);
        return response()->json($plan, 201);
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return response()->json($subscriptionPlan);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $subscriptionPlan->update($data);
        return response()->json($subscriptionPlan);
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();
        return response()->json(null, 204);
    }
}
