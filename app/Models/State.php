<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all addresses in this state
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get all doctor licenses in this state
     */
    public function doctorLicenses(): HasMany
    {
        return $this->hasMany(DoctorLicense::class);
    }

    /**
     * Scope to get only active states
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get states by country
     */
    public function scopeByCountry($query, $country = 'US')
    {
        return $query->where('country', $country);
    }

    /**
     * Get state by code
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get all US states
     */
    public static function getUSStates()
    {
        return static::active()->byCountry('US')->orderBy('name')->get();
    }
}
