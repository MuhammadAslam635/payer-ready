<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGatewayPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_gateway_id',
        'transaction_id',
        'screenshot_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * Get the transaction for this payment
     */
    public function transaction()
    {
        return Transaction::where('metadata->user_gateway_payment_id', $this->id)->first();
    }
}


