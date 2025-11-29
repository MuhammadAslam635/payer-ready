<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'issue_date',
        'expiration_date',
        'issuing_authority',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user (organization) that owns the license
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
