<?php

namespace App\Services;

use App\Models\PromotionSlot;

class PromotionSlotService
{
    /**
     * Create new slot
     */
    public function create(array $data): PromotionSlot
    {
        $slot = PromotionSlot::create($data);

        AuditLogService::log(
            auth()->id(),
            'create_promotion_slot',
            'promotion_slot',
            $slot->id,
            [],
            $slot->toArray()
        );

        return $slot;
    }

    /**
     * Update existing slot (price, max_slots, visibility_weight)
     */
    public function update(PromotionSlot $slot, array $data): PromotionSlot
    {
        $old = $slot->toArray();
        $slot->update($data);

        AuditLogService::log(
            auth()->id(),
            'update_promotion_slot',
            'promotion_slot',
            $slot->id,
            $old,
            $slot->toArray()
        );

        return $slot;
    }

    /**
     * Deactivate / Delete slot
     */
    public function delete(PromotionSlot $slot): void
    {
        $old = $slot->toArray();
        $slot->delete();

        AuditLogService::log(
            auth()->id(),
            'delete_promotion_slot',
            'promotion_slot',
            $slot->id,
            $old,
            []
        );
    }
}
