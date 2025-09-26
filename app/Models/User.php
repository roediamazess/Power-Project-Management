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

    // Tier constants
    const TIER_NEW_BORN = 'New Born';
    const TIER_1 = 'Tier 1';
    const TIER_2 = 'Tier 2';
    const TIER_3 = 'Tier 3';

    // Role constants
    const ROLE_ADMINISTRATOR = 'Administrator';
    const ROLE_MANAGEMENT = 'Management';
    const ROLE_ADMIN_OFFICER = 'Admin Officer';
    const ROLE_USER = 'User';
    const ROLE_CLIENT = 'Client';

    // Status constants
    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'tier',
        'role',
        'start_work',
        'birthday',
        'status',
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
            'start_work' => 'date',
            'birthday' => 'date',
        ];
    }

    /**
     * Get all tier options
     */
    public static function getTierOptions()
    {
        return [
            'New Born',
            'Tier 1',
            'Tier 2',
            'Tier 3',
        ];
    }

    /**
     * Get all role options
     */
    public static function getRoleOptions()
    {
        return [
            'Administrator',
            'Management',
            'Admin Officer',
            'User',
            'Client',
        ];
    }

    /**
     * Get all status options
     */
    public static function getStatusOptions()
    {
        return [
            'Active',
            'Inactive',
        ];
    }

    /**
     * Check if user is administrator
     */
    public function isAdministrator(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    /**
     * Check if user is management
     */
    public function isManagement(): bool
    {
        return $this->role === self::ROLE_MANAGEMENT;
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
