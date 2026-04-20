<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RefundPolicy extends Model
{
    use HasTranslations;

    public array $translatable = [
        'label', 'max_auto_approve_amount', 'finance_approval_threshold',
        'max_refunds_per_month', 'fraud_score_block_threshold',
        'completion_refund_matrix', 'policy_key',
    ];

    protected $fillable = [
        'policy_key', 'label',
        'max_auto_approve_amount',
        'finance_approval_threshold',
        'max_refunds_per_month',
        'fraud_score_block_threshold',
        'completion_refund_matrix',
        'is_active', 'translations',
    ];

    protected $casts = [
        'completion_refund_matrix' => 'array',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public static function getActive(): self
    {
        return self::where('is_active', true)->firstOrFail();
    }
}
