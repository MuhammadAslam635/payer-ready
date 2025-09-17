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
    ];

    /**
     * Get all tasks of this type
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(DoctorTask::class);
    }
}






