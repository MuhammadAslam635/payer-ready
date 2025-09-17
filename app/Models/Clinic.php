<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'address',
        'city',
        'state_id',
        'zip_code',
        'phone',
        'email',
        'website',
        'tax_id',
        'npi_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user (doctor/provider) that owns this clinic
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the state where the clinic is located
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Scope to get active clinics
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the display name (business name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->business_name;
    }

    /**
     * Get the full address
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state?->name,
            $this->zip_code,
        ]);

        return implode(', ', $parts);
    }
}
