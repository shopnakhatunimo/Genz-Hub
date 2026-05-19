<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'name',
        'email',
        'phone',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status',
        'order_status',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'coupon_code',
        'notes',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'ORD-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'অপেক্ষমান',
            'confirmed' => 'নিশ্চিত',
            'processing' => 'প্রক্রিয়াধীন',
            'shipped' => 'পাঠানো হয়েছে',
            'delivered' => 'ডেলিভারি হয়েছে',
            'cancelled' => 'বাতিল',
        ];
        return $labels[$this->order_status] ?? $this->order_status;
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'অপেক্ষমান',
            'paid' => 'পরিশোধিত',
            'failed' => 'ব্যর্থ',
            'refunded' => 'রিফান্ড',
        ];
        return $labels[$this->payment_status] ?? $this->payment_status;
    }
}
