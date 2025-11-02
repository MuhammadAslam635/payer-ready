<?php

namespace App\Models;

use App\Enums\LicenseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_type_id',
        'state_id',
        'license_number',
        'issue_date',
        'expiration_date',
        'status',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_notes',
        'issuing_authority',
        'notes',
        'document',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'status' => LicenseStatus::class,
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the license
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

