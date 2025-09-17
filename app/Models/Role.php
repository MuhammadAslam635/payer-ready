<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that have this role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
                    ->withPivot(['organization_id', 'is_active', 'assigned_at', 'expires_at'])
                    ->withTimestamps();
    }
}
