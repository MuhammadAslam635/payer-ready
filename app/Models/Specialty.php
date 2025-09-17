<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'taxonomy_code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that have this specialty
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_specialties')
                    ->withPivot(['is_primary'])
                    ->withTimestamps();
    }
}






