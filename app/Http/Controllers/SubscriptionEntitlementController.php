<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionEntitlement;
use App\Services\SubscriptionEntitlementService;
use Illuminate\Http\Request;

class SubscriptionEntitlementController extends Controller
{
    public function index()
    {
        return SubscriptionEntitlement::get();
        // if (! $subscriptionEntitlements) {
        //     return response()->json(['message' => 'No subscription entitlements found'], 404);
        // }

        // return response()->json($subscriptionEntitlements);
    }

    public function store(
        Request $request,
        SubscriptionEntitlementService $service
    ) {
        $data = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'feature_key' => 'required|string',
            'feature_value' => 'required|string',
        ]);

        return $service->create($data);
    }

    public function show($id)
    {
        $subscriptionEntitlement = SubscriptionEntitlement::findOrFail($id);

        return response()->json($subscriptionEntitlement);
    }

    public function update(
        Request $request,
        SubscriptionEntitlement $subscriptionEntitlement,
        SubscriptionEntitlementService $service
    ) {
        $data = $request->validate([
            'feature_key' => 'sometimes|string',
            'feature_value' => 'sometimes|string',
        ]);

        return $service->update($subscriptionEntitlement, $data);
    }

    public function destroy($id)
    {
        $subscriptionEntitlement = SubscriptionEntitlement::findOrFail($id);
        $subscriptionEntitlement->delete();

        return response()->json(['message' => 'Entitlement removed']);
    }
}
