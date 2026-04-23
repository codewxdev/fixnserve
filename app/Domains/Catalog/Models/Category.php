<?php

namespace App\Domains\Catalog\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['name', 'type'];

    protected $hidden = ['created_at', 'updated_at'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function specialties()
    {
        return $this->hasMany(Subcategory::class);
    }
}
