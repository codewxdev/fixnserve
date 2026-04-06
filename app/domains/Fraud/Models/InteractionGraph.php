<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class InteractionGraph extends Model
{
    use HasTranslations;

    protected $fillable = [
        'actor_a_type', 'actor_a_id',
        'actor_b_type', 'actor_b_id',
        'interaction_type', 'interaction_count',
        'avg_completion_time', 'shared_gps',
        'no_chat_history', 'anomaly_score',
        'is_suspicious', 'translations',
    ];

    protected $casts = [
        'shared_gps' => 'boolean',
        'no_chat_history' => 'boolean',
        'is_suspicious' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeSuspicious($query)
    {
        return $query->where('is_suspicious', true);
    }
}
