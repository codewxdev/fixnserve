<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionPurchases extends Model
{
    protected $fillable = [
        'provider_id',
        'promotion_id',
        'starts_at',
        'ends_at',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
