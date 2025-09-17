<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_suspended',
        'felony_conviction',
        'malpractice_claims',
        'additional_notes',
        'attested_at',
    ];

    protected $casts = [
        'license_suspended' => 'boolean',
        'felony_conviction' => 'boolean',
        'malpractice_claims' => 'boolean',
        'attested_at' => 'datetime',
    ];

    /**
     * Get the user that owns this attestation record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
