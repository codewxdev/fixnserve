<?php

namespace App\Domains\Catalog\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
