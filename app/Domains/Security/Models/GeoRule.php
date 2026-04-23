<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class GeoRule extends Model
{
    protected $fillable = [
        'country_code',
        'status',
        'is_default',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
