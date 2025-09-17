<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'institution_name',
        'degree',
        'field_of_study',
        'graduation_date',
        'gpa',
        'is_active',
    ];

    protected $casts = [
        'graduation_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns this education record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}