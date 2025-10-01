<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'provider',
        'configuration',
        'is_active',
        'is_test_mode',
        'barcode_screenshot_path',
        'wallet_uri',
        'is_local_payment',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'is_local_payment' => 'boolean',
    ];
}






