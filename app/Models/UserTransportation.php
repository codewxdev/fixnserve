<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bicycle',
        'car',
        'scooter',
        'truck',
        'walk',
    ];

    protected $casts = [
        'bicycle' => 'boolean',
        'car' => 'boolean',
        'scooter' => 'boolean',
        'truck' => 'boolean',
        'walk' => 'boolean',
    ];

    protected $appends = [
        'active_transportations',
    ];

    /**
     * Get the user that owns the transportation settings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor to get list of active transportations
     */
    public function getActiveTransportationsAttribute()
    {
        $active = [];

        if ($this->bicycle) {
            $active[] = 'Bicycle';
        }
        if ($this->car) {
            $active[] = 'Car';
        }
        if ($this->scooter) {
            $active[] = 'Scooter';
        }
        if ($this->truck) {
            $active[] = 'Truck';
        }
        if ($this->walk) {
            $active[] = 'Walk';
        }

        return $active;
    }

    /**
     * Check if any transportation is selected
     */
    public function hasAnyTransportation()
    {
        return $this->bicycle || $this->car || $this->scooter || $this->truck || $this->walk;
    }

    /**
     * Reset all transportation to false
     */
    public function resetAll()
    {
        $this->update([
            'bicycle' => false,
            'car' => false,
            'scooter' => false,
            'truck' => false,
            'walk' => false,
        ]);
    }
}
