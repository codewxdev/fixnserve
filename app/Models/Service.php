<?php

namespace App\Models;

use App\Domains\Catalog\Admin\Models\Subcategory;
use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'price_per_hour',
        'fee',
        'description',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'service_subcategories');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }
}
