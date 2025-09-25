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
        'completed_year',
        'gpa',
    ];

    protected $casts = [
        'completed_year' => 'integer',
    ];

    /**
     * Get the user that owns this education record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
