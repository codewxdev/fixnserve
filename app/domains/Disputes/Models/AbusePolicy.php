<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AbusePolicy extends Model
{
    use HasTranslations;

    protected $fillable = [
        'policy_key', 'label',
        'max_disputes_per_month',
        'max_refunds_per_month',
        'false_claim_threshold',
        'refund_amount_threshold',
        'coordinated_complaint_threshold',
        'auto_enforce', 'is_active', 'translations',
    ];

    protected $casts = [
        'auto_enforce' => 'boolean',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public static function getActive(): self
    {
        return self::where('is_active', true)->firstOrFail();
    }
}
