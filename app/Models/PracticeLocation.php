<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'practice_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'specialty',
        'npi_type_1',
        'npi_type_2',
        'tax_id',
        'office_phone',
        'office_fax',
        'is_primary',
        'is_secondary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_secondary' => 'boolean',
    ];

    /**
     * Get the user that owns the practice location
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full address as a single string
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;
        
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        
        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->zip_code;
        
        if ($this->country !== 'US') {
            $address .= ', ' . $this->country;
        }
        
        return $address;
    }
}
