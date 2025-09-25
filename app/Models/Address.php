<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'state_id',
        'country',
        'address_type',
        'is_primary',
        'user_id',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the state for this address
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the user for this address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

