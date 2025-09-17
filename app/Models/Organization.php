<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'tax_id',
        'npi',
        'phone',
        'website',
        'description',
        'admin_user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin user for this organization
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Get all addresses for this organization
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get all clinics for this organization
     */
    public function clinics(): HasMany
    {
        return $this->hasMany(Clinic::class);
    }

    /**
     * Get all staff members for this organization
     */
    public function staff(): HasMany
    {
        return $this->hasMany(OrganizationStaff::class);
    }
}
