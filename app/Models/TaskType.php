<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'default_priority',
        'estimated_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_priority' => 'integer',
    ];

    /**
     * Convert priority string to integer for database storage
     */
    public function setDefaultPriorityAttribute($value)
    {
        $priorities = [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            'urgent' => 4,
        ];

        $this->attributes['default_priority'] = is_string($value) ? ($priorities[$value] ?? $value) : $value;
    }

    /**
     * Convert priority integer to string for display
     */
    public function getDefaultPriorityAttribute($value)
    {
        $priorities = [
            1 => 'low',
            2 => 'medium',
            3 => 'high',
            4 => 'urgent',
        ];

        return $priorities[$value] ?? $value;
    }

    /**
     * Get all tasks of this type
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(DoctorTask::class, 'task_type_id');
    }
}






