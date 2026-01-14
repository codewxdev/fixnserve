<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionSlot extends Model
{
    protected $fillable = [
        'promotion_id',
        'max_slots',
        'used_slots',
        'visibility_weight',
        'price',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function hasAvailability(): bool
    {
        return $this->used_slots < $this->max_slots;
    }
}
