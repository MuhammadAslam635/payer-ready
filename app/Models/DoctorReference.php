<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_profile_id',
        'reference_full_name',
        'reference_title',
        'reference_specialty',
        'organization_name',
        'phone',
        'email',
        'relationship_type',
        'years_known',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the doctor profile that owns the reference
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }
}






