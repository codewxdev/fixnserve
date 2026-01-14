<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return SubscriptionPlan::with('entitlements')->get();
    }

    public function store(Request $request, SubscriptionPlanService $service)
    {
        $data = $request->validate([
            'app_id' => 'required|exists:apps,id',
            'name' => 'required|string',
            'tier' => 'required|string',
            'billing_cycle' => 'required|in:monthly,yearly',
            'price' => 'required|numeric|min:0',
            'visibility_weight' => 'required|integer',
        ]);
        

        return $service->create($data);
    }

    public function update(
        Request $request,
        SubscriptionPlan $subscriptionPlan,
        SubscriptionPlanService $service
    ) {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'tier' => 'sometimes|string',
            'billing_cycle' => 'sometimes|in:monthly,yearly',
            'price' => 'sometimes|numeric|min:0',
            'visibility_weight' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        return $service->update($subscriptionPlan, $data);
    }

    public function show($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        if (! $subscriptionPlan) {
            return response()->json(['message' => 'Plan not found'], 404);
        }

        return response()->json($subscriptionPlan);
    }

    public function destroy($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        $subscriptionPlan->delete();
        if (! $subscriptionPlan) {
            return response()->json(['message' => 'Plan not found'], 404);
        }

        return response()->json(['message' => 'Plan deleted']);
    }
}
