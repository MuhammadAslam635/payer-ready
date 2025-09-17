<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'state_id',
        'zip_code',
        'country',
        'address_type',
        'addressable_id',
        'addressable_type',
        'is_primary',
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
     * Get the parent addressable model (User, Organization, etc.)
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}

