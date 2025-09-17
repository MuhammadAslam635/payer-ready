<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'middle_name',
        'date_of_birth',
        'ssn',
        'home_address',
        'practice_address',
        'phone_number',
        'npi_number',
        'caqh_id',
        'caqh_login',
        'caqh_password',
        'pecos_login',
        'pecos_password',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns this personal info
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}