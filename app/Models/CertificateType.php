<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'issuing_organization',
        'validity_years',
        'requires_renewal',
        'is_active',
        'default_amount',
    ];

    protected $casts = [
        'requires_renewal' => 'boolean',
        'is_active' => 'boolean',
        'default_amount' => 'decimal:2',
    ];

    /**
     * Get all certificates of this type
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(DoctorCertificate::class);
    }
}






