<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_profile_id',
        'credential_type',
        'credential_name',
        'issuing_organization',
        'credential_number',
        'issue_date',
        'expiration_date',
        'status',
        'state',
        'description',
        'metadata',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'metadata' => 'array',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the doctor profile that owns this credential
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    /**
     * Get the user who verified this credential
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
