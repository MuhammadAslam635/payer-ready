<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'max_file_size_mb',
        'allowed_extensions',
        'is_required',
        'is_active',
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all documents of this type
     */
    public function documents(): HasMany
    {
        return $this->hasMany(DoctorDocument::class);
    }
}






