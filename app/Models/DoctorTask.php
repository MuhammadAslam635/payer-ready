<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_profile_id',
        'task_type_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_date',
        'assigned_to',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    /**
     * Get the doctor profile this task belongs to
     */
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    /**
     * Get the task type
     */
    public function taskType(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    /**
     * Get the user assigned to this task
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who created this task
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}






