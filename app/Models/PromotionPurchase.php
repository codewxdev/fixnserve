<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionPurchase extends Model
{
    protected $fillable = [
        'app_id',
        'user_id',
        'promotion_id',
        'promotion_slot_id',
        'starts_at',
        'expires_at',
        'is_active',
        'amount_paid',
        'currency',
        'payment_status',
        'payment_reference',
        'cancelled_at',
        'meta',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'cancelled_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * The app this promotion belongs to
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
    }

    /**
     * The user who purchased the promotion
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The promotion that was purchased
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * The slot that was bought
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(PromotionSlot::class, 'promotion_slot_id');
    }

    /**
     * Check if the promotion is currently active
     */
    public function isActive(): bool
    {
        $now = now();

        return $this->is_active && $this->starts_at <= $now && $this->expires_at >= $now;
    }
}
