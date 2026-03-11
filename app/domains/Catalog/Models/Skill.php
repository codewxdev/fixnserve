<?php

namespace App\Domains\Catalog\Models;

use App\Models\Portfolio;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['name'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_skills');
    }
}
