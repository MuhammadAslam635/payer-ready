<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type_id',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_size_bytes',
        'mime_type',
        'file_hash',
        'upload_date',
        'is_verified',
        'verified_at',
        'verified_by',
        'version',
        'is_current',
        'notes',
    ];

    protected $casts = [
        'upload_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'is_current' => 'boolean',
    ];

    /**
     * Get the user that owns the document
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the document type
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Get the user who verified this document
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}






