<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorWorkHistory extends Model
{
    use HasFactory;

    protected $table = 'doctor_work_history';

    protected $fillable = [
        'doctor_profile_id',
        'organization_name',
        'position_title',
        'department',
        'work_address_id',
        'start_date',
        'end_date',
        'is_current',
        'supervisor_name',
        'supervisor_phone',
        'description',
        'responsibilities',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the doctor profile this work history belongs to
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    /**
     * Get the work address
     */
    public function workAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'work_address_id');
    }
}
