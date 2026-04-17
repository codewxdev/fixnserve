<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EscalationRule extends Model
{
    use HasTranslations;

    public array $translatable = ['rule_key', 'from_role', 'to_role', 'trigger_on'];

    protected $fillable = [
        'rule_key', 'from_role', 'to_role',
        'trigger_after_hours', 'trigger_on',
        'auto_escalate', 'notify_supervisor',
        'is_active', 'translations',
    ];

    protected $casts = [
        'auto_escalate' => 'boolean',
        'notify_supervisor' => 'boolean',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
