<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
    use HasTranslations;

    public array $translatable = ['name',
    ];

    protected $fillable = ['name'];
}
