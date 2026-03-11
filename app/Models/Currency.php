<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'is_active',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
