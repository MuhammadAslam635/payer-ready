<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credentialing extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_profile_id',
        'organization_id',
        'status',
        'application_date',
        'review_start_date',
        'review_end_date',
        'approval_date',
        'expiration_date',
        'reviewed_by',
        'review_notes',
        'rejection_reason',
        'required_documents',
        'submitted_documents',
        'missing_documents',
        'is_urgent',
        'priority_level',
    ];

    protected $casts = [
        'application_date' => 'date',
        'review_start_date' => 'date',
        'review_end_date' => 'date',
        'approval_date' => 'date',
        'expiration_date' => 'date',
        'required_documents' => 'array',
        'submitted_documents' => 'array',
        'missing_documents' => 'array',
        'is_urgent' => 'boolean',
    ];

    /**
     * Get the doctor profile for this credentialing
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    /**
     * Get the organization for this credentialing
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user who reviewed this credentialing
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}






