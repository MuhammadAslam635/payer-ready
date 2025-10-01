<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'amount',
        'itemable_id',
        'itemable_type',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the invoice that owns the invoice item.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the owning itemable model (Insurance, Certificate, License, etc.).
     */
    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Calculate the amount based on quantity and unit price.
     */
    public function calculateAmount(): void
    {
        $this->amount = $this->quantity * $this->unit_price;
    }

    /**
     * Boot the model and set up event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically calculate amount when creating or updating
        static::saving(function ($invoiceItem) {
            $invoiceItem->calculateAmount();
        });

        // Update invoice totals when invoice item is saved or deleted
        static::saved(function ($invoiceItem) {
            $invoiceItem->invoice->calculateTotals();
        });

        static::deleted(function ($invoiceItem) {
            $invoiceItem->invoice->calculateTotals();
        });
    }
}
