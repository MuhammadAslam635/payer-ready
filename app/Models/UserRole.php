<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'organization_id',
        'is_active',
        'assigned_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'assigned_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the role assignment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role that is assigned
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the organization where this role is assigned
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}






