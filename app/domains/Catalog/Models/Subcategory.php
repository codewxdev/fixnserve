<?php

namespace App\Domains\Catalog\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['category_id', 'name'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specialties()
    {
        return $this->hasMany(Specialty::class);
    }
}
