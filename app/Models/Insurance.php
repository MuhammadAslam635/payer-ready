<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'carrier',
        'policy_number',
        'coverage_amount',
        'effective_date',
        'expiration_date',
        'is_active',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiration_date' => 'date',
        'is_active' => 'boolean',
        'coverage_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns this insurance record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
