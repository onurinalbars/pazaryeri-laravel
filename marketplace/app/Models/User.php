<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_VENDOR = 'vendor';
    public const ROLE_USER = 'user';

    public const VENDOR_STATUS_PENDING = 'pending';
    public const VENDOR_STATUS_APPROVED = 'approved';
    public const VENDOR_STATUS_SUSPENDED = 'suspended';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'vendor_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'vendor_status' => 'string',
        ];
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isVendor(): bool
    {
        return $this->role === self::ROLE_VENDOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function hasApprovedVendorStatus(): bool
    {
        return $this->isVendor() && $this->vendor_status === self::VENDOR_STATUS_APPROVED;
    }

    public function hasPendingVendorStatus(): bool
    {
        return $this->isVendor() && $this->vendor_status === self::VENDOR_STATUS_PENDING;
    }
}
