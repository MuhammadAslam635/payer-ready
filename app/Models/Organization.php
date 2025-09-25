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
        'is_admin',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the admin user for this organization
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Get all staff members for this organization
     */
    public function staff(): HasMany
    {
        return $this->hasMany(OrganizationStaff::class);
    }
}
