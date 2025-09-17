<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LicenseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'issuing_authority',
        'validity_years',
        'requires_renewal',
        'is_active',
    ];

    protected $casts = [
        'requires_renewal' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all licenses of this type
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(DoctorLicense::class);
    }
}






