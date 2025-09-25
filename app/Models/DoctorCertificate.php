<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_type_id',
        'certificate_name',
        'issuing_organization',
        'issue_date',
        'expiration_date',
        'certificate_number',
        'is_current',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the user that owns the certificate
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the certificate type
     */
    public function certificateType(): BelongsTo
    {
        return $this->belongsTo(CertificateType::class);
    }
}






