<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_profile_id',
        'license_type_id',
        'state_id',
        'license_number',
        'issue_date',
        'expiration_date',
        'status',
        'issuing_authority',
        'is_primary',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'is_primary' => 'boolean',
    ];

    /**
     * Get the doctor profile that owns the license
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    /**
     * Get the license type
     */
    public function licenseType(): BelongsTo
    {
        return $this->belongsTo(LicenseType::class);
    }

    /**
     * Get the state for this license
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}

