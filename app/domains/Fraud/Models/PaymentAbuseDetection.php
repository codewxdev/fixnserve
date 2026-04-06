<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PaymentAbuseDetection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'entity_type', 'entity_id', 'entity_ref',
        'transaction_type', 'amount', 'transaction_ref',
        'abuse_pattern', 'pattern_detail', 'confidence_score',
        'severity', 'auto_action', 'status',
        'finance_module_updated', 'meta', 'translations',
    ];

    protected $casts = [
        'finance_module_updated' => 'boolean',
        'meta' => 'array',
        'translations' => 'array',
    ];

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['detected', 'under_review']);
    }

    public function scopeByCritical($query)
    {
        return $query->where('severity', 'critical');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
