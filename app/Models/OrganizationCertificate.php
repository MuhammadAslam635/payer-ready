<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_number',
        'issue_date',
        'expiration_date',
        'issuing_organization',
        'notes',
        'is_current',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the user (organization) that owns the certificate
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
