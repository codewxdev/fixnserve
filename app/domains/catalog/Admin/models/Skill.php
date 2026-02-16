<?php

namespace App\Domains\Catalog\Admin\Models;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
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
