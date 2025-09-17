<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'organization_id',
        'type',
        'status',
        'amount',
        'currency',
        'payment_method',
        'payment_gateway',
        'gateway_transaction_id',
        'description',
        'metadata',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization for this transaction
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}






