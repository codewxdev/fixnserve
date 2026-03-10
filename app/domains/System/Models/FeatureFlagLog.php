<?php

namespace App\Domains\System\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class FeatureFlagLog extends Model
{
    protected $fillable = ['feature_flag_id', 'changed_by', 'old_value', 'new_value'];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    public function featureFlag()
    {
        return $this->belongsTo(FeatureFlag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
