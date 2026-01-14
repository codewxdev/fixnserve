<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'name',
        'app_key',
    ];

    public function plans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}
