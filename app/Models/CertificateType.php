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
        'certificate_number',
        'description',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'requires_renewal',
        'is_active',
    ];

    protected $casts = [
        'requires_renewal' => 'boolean',
        'is_active' => 'boolean',
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get all certificates of this type
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(DoctorCertificate::class);
    }
}






