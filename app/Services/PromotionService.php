<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function create(array $data): Promotion
    {
        $promotion = Promotion::create($data);

        AuditLogService::log(
            auth()->id(),
            'create_promotion',
            'promotion',
            $promotion->id,
            [],
            $promotion->toArray()
        );

        return $promotion;
    }

    public function update(Promotion $promotion, array $data): Promotion
    {
        $old = $promotion->toArray();

        $promotion->update($data);

        AuditLogService::log(
            auth()->id(),
            'update_promotion',
            'promotion',
            $promotion->id,
            $old,
            $promotion->toArray()
        );

        return $promotion;
    }

    public function delete(Promotion $promotion): void
    {
        $old = $promotion->toArray();

        $promotion->delete();

        AuditLogService::log(
            auth()->id(),
            'delete_promotion',
            'promotion',
            $promotion->id,
            $old,
            []
        );
    }
}
