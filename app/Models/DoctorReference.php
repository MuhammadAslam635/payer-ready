<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'title',
        'address',
        'phone',
        'email',
    ];

    /**
     * Get the user that owns the reference
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}






