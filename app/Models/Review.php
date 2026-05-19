<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'images',
        'is_verified',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'images' => 'array',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            $product = $review->product;
            $product->rating = $product->reviews()->where('is_approved', true)->avg('rating');
            $product->review_count = $product->reviews()->where('is_approved', true)->count();
            $product->save();
        });

        static::deleted(function ($review) {
            $product = $review->product;
            $product->rating = $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
            $product->review_count = $product->reviews()->where('is_approved', true)->count();
            $product->save();
        });
    }
}
