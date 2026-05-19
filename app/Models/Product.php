<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'discount_price',
        'stock',
        'sold_count',
        'view_count',
        'rating',
        'review_count',
        'sku',
        'brand',
        'variants',
        'is_featured',
        'is_trending',
        'is_flash_sale',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'variants' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_flash_sale' => 'boolean',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ? $this->discount_price : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getPrimaryImageUrlAttribute()
    {
        if ($this->primaryImage) {
            return asset('uploads/products/' . $this->primaryImage->image);
        }
        if ($this->images->first()) {
            return asset('uploads/products/' . $this->images->first()->image);
        }
        return asset('assets/images/default-product.png');
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
