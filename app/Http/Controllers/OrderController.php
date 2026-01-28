<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\RiderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): JsonResponse
    {
        // 1️⃣ Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'searching',
            'transport_type_id' => $request->transport_type_id,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lng' => $request->pickup_lng,
            'drop_lat' => $request->drop_lat,
            'drop_lng' => $request->drop_lng,
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
                'data' => $order,
            ], 201);
        }

        // 3️⃣ Filter eligible riders
        $riderIds = collect($nearbyRiders)->pluck(0)->map(fn ($id) => (int) $id);

        $eligibleRiders = DB::table('rider_vehicles')
            ->whereIn('rider_id', $riderIds)
            ->where('transport_type_id', $order->vehicle_type_id)
            ->where('is_active', true)
            ->pluck('rider_id')
            ->toArray();

        // 4️⃣ Create requests + notify
        foreach ($nearbyRiders as [$riderId, $distance]) {

            if (! in_array((int) $riderId, $eligibleRiders)) {
                continue;
            }

            RiderRequest::create([
                'order_id' => $order->id,
                'rider_id' => $riderId,
                'status' => 'pending',
                'sent_at' => now(),
            ]);

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
            'data' => $order,
        ], 201);

    }

    public function accept(Request $request, int $orderId): JsonResponse
    {
        $riderId = auth()->id();
        $lockKey = "order:lock:$orderId";

        // 1️⃣ Acquire Redis lock (5 sec)
        $lock = Redis::set($lockKey, $riderId, 'NX', 'EX', 5);

        if (! $lock) {
            return response()->json([
                'success' => false,
                'message' => 'Order already being accepted by another rider',
            ], 409);
        }

        try {
            $order = DB::transaction(function () use ($orderId, $riderId) {

                // 2️⃣ Lock order row
                $order = Order::where('id', $orderId)
                    ->where('status', 'searching')
                    ->lockForUpdate()
                    ->first();

                if (! $order) {
                    throw new \Exception('Order not available');
                }

                // 3️⃣ Update order
                $order->update([
                    'status' => 'assigned',
                    'rider_id' => $riderId,
                ]);

                // 4️⃣ Update rider request
                RiderRequest::where('order_id', $orderId)
                    ->where('rider_id', $riderId)
                    ->update(['status' => 'accepted']);

                // 5️⃣ Reject all others
                RiderRequest::where('order_id', $orderId)
                    ->where('rider_id', '!=', $riderId)
                    ->update(['status' => 'rejected']);

                return $order;
            });

        } catch (\Throwable $e) {

            Redis::del($lockKey);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);
        }

        // 6️⃣ Release lock
        Redis::del($lockKey);

        // 7️⃣ Notify others
        // $this->notifyOrderAccepted($order, $riderId);

        return response()->json([
            'success' => true,
            'message' => 'Order accepted successfully',
            'data' => $order,
        ]);
    }

    public function update(Request $request)
    {
        $riderId = auth()->id();

        Redis::geoadd(
            'riders:locations',   // GEO key
            $request->lng,        // longitude
            $request->lat,        // latitude
            $riderId              // member
        );

        // optional TTL (offline detection)
        Redis::expire("rider:online:$riderId", 15);

        return response()->json(['success' => true]);
    }
}
