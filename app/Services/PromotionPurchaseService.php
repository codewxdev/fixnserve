<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\PromotionPurchase;
use App\Models\PromotionSlot;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class PromotionPurchaseService
{
    /**
     * Safely purchase a promotion slot
     */
    public function purchase(int $userId, int $appId, Promotion $promotion, PromotionSlot $slot, string $paymentReference): PromotionPurchase
    {
        return DB::transaction(function () use ($userId, $appId, $promotion, $slot, $paymentReference) {

            // Lock the slot row to prevent overbooking
            $slot = PromotionSlot::where('id', $slot->id)->lockForUpdate()->first();

            if (! $promotion->is_active) {
                throw new Exception('Promotion is not active');
            }

            if ($slot->used_slots >= $slot->max_slots) {
                throw new Exception('No promotion slots available');
            }

            $startsAt = Carbon::now();
            $expiresAt = $startsAt->copy()->addHours($promotion->duration_hours);

            $purchase = PromotionPurchase::create([
                'app_id' => $appId,
                'user_id' => $userId,
                'promotion_id' => $promotion->id,
                'promotion_slot_id' => $slot->id,
                'starts_at' => $startsAt,
                'expires_at' => $expiresAt,
                'is_active' => true,
                'amount_paid' => $slot->price,
                'currency' => 'PKR',
                'payment_status' => 'paid',
                'payment_reference' => $paymentReference,
            ]);

            // Increment slot usage
            $slot->increment('used_slots');

            return $purchase;
        });
    }
}
