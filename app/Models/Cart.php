<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_code',
        'discount',
        'subtotal',
        'total',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function getItemCount()
    {
        return $this->items->sum('quantity');
    }

    public function updateTotals()
    {
        $this->subtotal = $this->items->sum('subtotal');
        
        if ($this->coupon) {
            if ($this->coupon->type === 'percentage') {
                $this->discount = ($this->subtotal * $this->coupon->value) / 100;
            } else {
                $this->discount = $this->coupon->value;
            }
            
            if ($this->coupon->max_discount && $this->discount > $this->coupon->max_discount) {
                $this->discount = $this->coupon->max_discount;
            }
        } else {
            $this->discount = 0;
        }
        
        $this->total = $this->subtotal - $this->discount;
        $this->save();
    }
}
