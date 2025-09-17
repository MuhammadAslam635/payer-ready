<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'transaction_fee_percentage',
        'transaction_fee_fixed',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'transaction_fee_percentage' => 'decimal:2',
        'transaction_fee_fixed' => 'decimal:2',
    ];
}






