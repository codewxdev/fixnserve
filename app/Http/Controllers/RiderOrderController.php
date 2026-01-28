<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RiderRequest;
use Illuminate\Support\Facades\DB;

class RiderOrderController extends Controller
{
    public function accept(Order $order)
    {

        $riderId = auth()->id();

        return DB::transaction(function () use ($order, $riderId) {

            // lock order row
            $order = Order::where('id', $order->id)
                ->lockForUpdate()
                ->first();

            // already taken?
            if ($order->status !== 'searching') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order already assigned',
                ], 409);
            }

            // assign rider
            $order->update([
                'rider_id' => $riderId,
                'status'   => 'assigned',
            ]);

            // accept this rider
            RiderRequest::where('order_id', $order->id)
                ->where('rider_id', $riderId)
                ->update(['status' => 'accepted']);

            // reject others
            RiderRequest::where('order_id', $order->id)
                ->where('rider_id', '!=', $riderId)
                ->update(['status' => 'rejected']);

            return response()->json([
                'success' => true,
                'message' => 'Order accepted successfully',
                'order'   => $order,
            ]);
        });

    }
}
