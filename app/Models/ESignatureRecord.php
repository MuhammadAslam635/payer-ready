<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ESignatureRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_version',
        'signature_text',
        'signature_date',
        'ip_address',
        'user_agent',
        'consent_text',
        'agreement_terms_version',
        'is_valid',
        'notes',
    ];

    protected $casts = [
        'signature_date' => 'datetime',
        'is_valid' => 'boolean',
    ];

    /**
     * Get the user that owns the e-signature record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}






