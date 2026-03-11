<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'iso2',
        'phone_code',
        'flag_url',
        'phone_length',
        'status',
        'default_language',
        'currency_code',
        'date_format',
        'default_language',
        'time_format',
        'decimal_separator',
        'thousand_separator',

    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }
}
