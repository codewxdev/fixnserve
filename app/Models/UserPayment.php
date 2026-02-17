<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class UserPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'payment_method',
        'payment_title',
        'is_default',
        'status',

        // Card
        'card_holder_name',
        'card_number',
        'card_type',
        'expiry_month',
        'expiry_year',
        'card_brand',
        'address_line',     // NEW
        'postal_code',      // NEW
        'city',             // NEW
        'currency',

        // JazzCash
        'jazzcash_account_number',
        'jazzcash_account_title',
        'jazzcash_cnic',
        'jazzcash_email',

        // EasyPaisa
        'easypaisa_account_number',
        'easypaisa_account_title',
        'easypaisa_cnic',
        'easypaisa_email',

        // Bank Transfer
        'bank_name',
        'account_title',
        'account_number',
        'iban',
        'branch_code',
        'branch_name',

        // Verification
        'verification_token',
        'verified_at',
        'token_expires_at',

        // Audit
        'last_four_digits',
        'fingerprint',
        'metadata',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'verified_at' => 'datetime',
        'token_expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected $appends = [
        'masked_card_number',
        'masked_account_number',
        'is_verified',
        'payment_method_name',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessors
     */
    public function getMaskedCardNumberAttribute()
    {
        if ($this->payment_method === 'card' && $this->last_four_digits) {
            return '**** **** **** '.$this->last_four_digits;
        }

        return null;
    }

    public function getMaskedAccountNumberAttribute()
    {
        if (in_array($this->payment_method, ['jazzcash', 'easypaisa']) && $this->jazzcash_account_number) {
            // Show only last 4 digits of mobile number
            $number = $this->jazzcash_account_number ?? $this->easypaisa_account_number;
            if (strlen($number) > 4) {
                return '******'.substr($number, -4);
            }

            return $number;
        }

        return null;
    }

    public function getIsVerifiedAttribute()
    {
        return ! is_null($this->verified_at);
    }

    public function getPaymentMethodNameAttribute()
    {
        $names = [
            'card' => 'Credit/Debit Card',
            'jazzcash' => 'JazzCash',
            'easypaisa' => 'EasyPaisa',
            'bank_transfer' => 'Bank Transfer',
        ];

        return $names[$this->payment_method] ?? ucfirst($this->payment_method);
    }

    public function getFormattedExpiryAttribute()
    {
        if ($this->payment_method === 'card' && $this->expiry_month && $this->expiry_year) {
            return $this->expiry_month.'/'.substr($this->expiry_year, -2);
        }

        return null;
    }

    /**
     * Mutators for encryption
     */
    public function setCardNumberAttribute($value)
    {
        if ($value) {
            // Store encrypted card number
            $this->attributes['card_number'] = Crypt::encryptString($value);
            // Store last 4 digits
            $this->attributes['last_four_digits'] = substr($value, -4);
        }
    }

    public function setJazzcashAccountNumberAttribute($value)
    {
        if ($value) {
            $this->attributes['jazzcash_account_number'] = Crypt::encryptString($value);
        }
    }

    public function setEasypaisaAccountNumberAttribute($value)
    {
        if ($value) {
            $this->attributes['easypaisa_account_number'] = Crypt::encryptString($value);
        }
    }

    public function setCvvHashAttribute($value)
    {
        if ($value) {
            $this->attributes['cvv_hash'] = bcrypt($value);
        }
    }

    /**
     * Decrypt card number (use with caution)
     */
    public function getDecryptedCardNumber()
    {
        if ($this->card_number) {
            return Crypt::decryptString($this->card_number);
        }

        return null;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    /**
     * Business Logic Methods
     */
    public function markAsDefault()
    {
        // Remove default from other payment methods
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->update(['is_default' => true]);
    }

    public function verify()
    {
        $this->update([
            'verified_at' => now(),
            'verification_token' => null,
            'token_expires_at' => null,
        ]);
    }

    public function isExpired()
    {
        if ($this->payment_method === 'card' && $this->expiry_month && $this->expiry_year) {
            $expiryDate = \Carbon\Carbon::createFromDate($this->expiry_year, $this->expiry_month, 1)->endOfMonth();

            return now()->gt($expiryDate);
        }

        return false;
    }

    public function getFullAddressAttribute()
    {
        if ($this->payment_method === 'card') {
            $parts = [];

            if ($this->address_line) {
                $parts[] = $this->address_line;
            }
            if ($this->city) {
                $parts[] = $this->city;
            }
            if ($this->postal_code) {
                $parts[] = $this->postal_code;
            }

            return implode(', ', $parts);
        }

        return null;
    }

    /**
     * NEW: Accessor for formatted currency
     */
    public function getFormattedCurrencyAttribute()
    {
        $currencies = [
            'USD' => '$',
            'PKR' => 'Rs ',
            'EUR' => '€',
            'GBP' => '£',
            'SAR' => 'SR ',
            'AED' => 'AED ',
        ];

        return $currencies[$this->currency] ?? $this->currency;
    }
}
