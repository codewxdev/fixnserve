<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class IpRule extends Model
{
    use HasTranslations;

    public array $translatable = ['cidr', 'type', 'applies_to', 'comment'];

    protected $fillable = [
        'cidr',
        'type',
        'applies_to',
        'comment',
        'expires_at',
        'is_active',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
