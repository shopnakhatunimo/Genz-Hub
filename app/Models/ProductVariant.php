<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'value',
        'price_adjustment',
        'stock',
        'sku',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'stock'            => 'integer',
    ];

    // ========================
    // Relationships
    // ========================

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ========================
    // Helpers
    // ========================

    /**
     * Get the adjusted price considering the variant price adjustment.
     */
    public function getFinalPriceAttribute(): float
    {
        $basePrice = $this->product->sale_price ?? $this->product->price;
        return max(0, $basePrice + $this->price_adjustment);
    }

    /**
     * Check if variant is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
