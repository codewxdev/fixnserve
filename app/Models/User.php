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
        'mode',
        'uuid',
        'lat',           // Added
        'lon',
        'country_id',  // Only country_id needed now
        // Added        // Added
        'phone_status',  // Added
        'rating',        // Added
        'favourite', // Add UUID to fillable
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
            'mode' => 'boolean', // Add this line

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

    public function transportation()
    {
        return $this->hasOne(UserTransportation::class);
    }

    public function notificationSettings()
    {
        return $this->hasMany(UserNotification::class);
    }

    // Get settings for a specific notification type
    public function getNotificationSettings($typeSlug)
    {
        return $this->notificationSettings()
            ->whereHas('notificationType', function ($q) use ($typeSlug) {
                $q->where('slug', $typeSlug);
            })
            ->first();
    }

    // Create default notification settings for a user
    public function createDefaultNotificationSettings()
    {
        $types = NotificationType::where('is_active', true)->get();

        foreach ($types as $type) {
            $this->notificationSettings()->updateOrCreate(
                ['notification_type_id' => $type->id],
                [
                    'email' => $type->default_channels['email'] ?? true,
                    'sms' => $type->default_channels['sms'] ?? false,
                    'push' => $type->default_channels['push'] ?? false,
                ]
            );
        }
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favourite::class);
    }

    // Favourite users
    public function favouriteUsers()
    {
        return $this->morphedByMany(
            User::class,
            'favouritable',
            'favorites'
        );
    }

    // Favourite services
    public function favouriteServices()
    {
        return $this->morphedByMany(
            Service::class,
            'favouritable',
            'favorites'
        );
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class);
    }

    // Ratings RECEIVED by user
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function wallet()
{
    return $this->hasOne(Wallet::class);
}
}
