<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'role_id',
        'position_title',
        'department',
        'start_date',
        'end_date',
        'is_active',
        'is_primary',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
    ];

    /**
     * Get the organization for this staff member
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user for this staff member
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role for this staff member
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
