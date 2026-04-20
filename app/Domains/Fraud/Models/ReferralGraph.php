<?php

namespace App\Domains\Fraud\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ReferralGraph extends Model
{
    use HasTranslations;

    public array $translatable = ['same_device', 'same_ip', 'is_suspicious', 'status'];

    protected $fillable = [
        'referrer_id', 'referee_id',
        'device_hash', 'ip_address',
        'same_device', 'same_ip',
        'is_suspicious', 'status', 'translations',
    ];

    protected $casts = [
        'same_device' => 'boolean',
        'same_ip' => 'boolean',
        'is_suspicious' => 'boolean',
        'translations' => 'array',
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function scopeSuspicious($query)
    {
        return $query->where('is_suspicious', true);
    }
}
