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
        'policy_effective_date',
        'policy_expiration_date',
        'status',
    ];

    protected $casts = [
        'policy_effective_date' => 'date',
        'policy_expiration_date' => 'date',
        'status' => 'string',
        'coverage_amount' => 'decimal:2',
    ];

    /**
     * Set the coverage amount attribute
     * Handle empty strings and null values gracefully
     */
    public function setCoverageAmountAttribute($value)
    {
        if (empty($value) || $value === '') {
            $this->attributes['coverage_amount'] = 0.00;
        } else {
            $this->attributes['coverage_amount'] = $value;
        }
    }

    /**
     * Get the user that owns this insurance record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
