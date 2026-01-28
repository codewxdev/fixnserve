<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\RiderRequest;

class OrderController extends Controller
{
   public function store(StoreOrderRequest $request): JsonResponse
   {
    // 1️⃣ Create order
    $order = Order::create([
        'user_id'    => auth()->id(),
        'status'     => 'searching',
        'vehicle_type_id' => $request->vehicle_type_id,
        'pickup_lat' => $request->pickup_lat,
        'pickup_lng' => $request->pickup_lng,
        'drop_lat'   => $request->drop_lat,
        'drop_lng'   => $request->drop_lng,
    ]);

    // 2️⃣ Find nearby riders (safe Redis)
    try {
        $nearbyRiders = Redis::georadius(
            'riders:locations',
            $order->pickup_lng,
            $order->pickup_lat,
            5,
            'km',
            'WITHDIST',
            'ASC',
            'COUNT', 5
        );
    } catch (\Throwable $e) {
        Log::error('Redis GEO failed', ['error' => $e->getMessage()]);
        $nearbyRiders = [];
    }

    if (empty($nearbyRiders)) {
        return response()->json([
            'success' => true,
            'message' => 'Order placed, searching for riders',
            'data' => $order
        ], 201);
    }

    // 3️⃣ Filter eligible riders
    $riderIds = collect($nearbyRiders)->pluck(0)->map(fn ($id) => (int)$id);

    $eligibleRiders = DB::table('rider_vehicles')
        ->whereIn('rider_id', $riderIds)
        ->where('transport_type_id', $order->vehicle_type_id)
        ->where('is_active', true)
        ->pluck('rider_id')
        ->toArray();

    // 4️⃣ Create requests + notify
    foreach ($nearbyRiders as [$riderId, $distance]) {

        if (!in_array((int)$riderId, $eligibleRiders)) {
            continue;
        }

        RiderRequest::updateOrCreate(
            ['order_id' => $order->id, 'rider_id' => $riderId],
            ['status' => 'pending', 'distance_km' => $distance]
        );

        Redis::publish("rider.notifications.$riderId", json_encode([
            'type' => 'NEW_ORDER',
            'order_id' => $order->id,
            'distance' => $distance,
            'pickup' => [
                'lat' => $order->pickup_lat,
                'lng' => $order->pickup_lng,
            ],
        ]));
    }

    // 5️⃣ Expiry TTL (optional but recommended)
    Redis::setex("order:searching:{$order->id}", 60, 1);
    return response()->json([
        'success' => true,
        'message' => 'Order placed and nearby eligible riders notified',
        'data' => $order
    ], 201);
    }

}
