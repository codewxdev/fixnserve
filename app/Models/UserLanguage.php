<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasTranslations;

    public array $translatable = ['language',
    ];

    protected $fillable = ['language', 'proficiency', 'user_id'];

    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    }
}
