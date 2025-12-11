<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    // UUID ke liye trait use karein
    use HasUuids;

    /**
     * Specify which column gets UUID
     */
    protected $uuidColumn = 'uuid';

    /**
     * Remove these lines - auto-increment id use kareinge
     * public $incrementing = false;
     * protected $keyType = 'string';
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid', // Add UUID to fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get columns that should receive UUIDs
     */
    public function uniqueIds(): array
    {
        return ['uuid']; // Sirf UUID column ko UUID assign karein
    }

    /**
     * Use UUID for route model binding
     */
    public function getRouteKeyName(): string
    {
        return 'uuid'; // Routes mein UUID use karein
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey(); // returns primary key = id
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'uuid' => $this->uuid,
            'roles' => $this->getRoleNames(),
        ];
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id');
    }

    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }

    public function certificates()
    {
        return $this->hasMany(UserCertificate::class);
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    /**
     * Get user's default payment method.
     */
    public function defaultPayment()
    {
        return $this->hasOne(UserPayment::class)->where('is_default', true);
    }

    /**
     * Get active payment methods.
     */
    public function activePayments()
    {
        return $this->payments()->active();
    }

    /**
     * Get card payment methods.
     */
    public function cardPayments()
    {
        return $this->payments()->byMethod('card');
    }

    /**
     * Get JazzCash payment methods.
     */
    public function jazzcashPayments()
    {
        return $this->payments()->byMethod('jazzcash');
    }

    /**
     * Get EasyPaisa payment methods.
     */
    public function easypaisaPayments()
    {
        return $this->payments()->byMethod('easypaisa');
    }
}
