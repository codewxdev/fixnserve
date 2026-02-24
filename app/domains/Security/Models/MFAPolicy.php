<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class MFAPolicy extends Model
{
    protected $table = 'mfa_policies';

    protected $fillable = ['enforcement_policy', 'allowed_methods'];

    protected $casts = ['allowed_methods' => 'array'];

    protected $hidden = ['created_at', 'updated_at'];

    public static function current()
    {
        return self::first() ?? self::create([
            'allowed_methods' => [],
        ]);
    }
}
