<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'npi_number',
        'dea_number',
        'dea_issue_date',
        'dea_expiry_date',
        'caqh_id',
        'status',
        'primary_specialty_id',
        'experience_years',
        'board_certified',
        'board_certification_date',
        'bio',
    ];

    protected $casts = [
        'board_certified' => 'boolean',
        'board_certification_date' => 'date',
        'dea_issue_date' => 'date',
        'dea_expiry_date' => 'date',
    ];

    /**
     * Get the user that owns the doctor profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the primary specialty
     */
    public function primarySpecialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'primary_specialty_id');
    }

    /**
     * Get all licenses for this doctor
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(DoctorLicense::class);
    }

    /**
     * Get all documents for this doctor
     */
    public function documents(): HasMany
    {
        return $this->hasMany(DoctorDocument::class);
    }
}






