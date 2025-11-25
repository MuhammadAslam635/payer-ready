<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'credential_name',
        'issuing_organization',
        'credential_number',
        'issue_date',
        'expiration_date',
        'status',
        'state_id',
        'description',
        'metadata',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_notes',
        'payer_id',
        'request_type',
        'submitted_at',
        'effective_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'effective_date' => 'date',
        'metadata' => 'array',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the user that owns this credential
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who verified this credential
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    public function state():BelongsTo{
        return $this->belongsTo(State::class);
    }
    public function payer():BelongsTo{
        return $this->belongsto(Payer::class);
    } 
}
