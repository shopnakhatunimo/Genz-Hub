@extends('layouts.frontend.app')

@section('title', 'কার্ট')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">আমার কার্ট</h1>
    
    @if($cart && $cart->items->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart->items as $item)
            <div class="bg-white rounded-xl p-4 shadow-sm flex items-center space-x-4">
                <img src="{{ $item->product->primaryImageUrl }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 class="font-medium text-gray-800">{{ $item->product->name }}</h3>
                    <p class="text-primary-600 font-bold">{{ formatPrice($item->price) }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-8 h-8 border rounded hover:bg-gray-100">-</button>
                    <span class="w-8 text-center">{{ $item->quantity }}</span>
                    <button onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-8 h-8 border rounded hover:bg-gray-100">+</button>
                </div>
                <p class="font-bold text-gray-800 w-24 text-right">{{ formatPrice($item->subtotal) }}</p>
                <button onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            @endforeach
        </div>
        
        <!-- Cart Summary -->
        <div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">অর্ডার সারাংশ</h2>
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">সাবটোটাল</span>
                        <span>{{ formatPrice($cart->subtotal) }}</span>
                    </div>
                    @if($cart->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>ডিসকাউন্ট</span>
                        <span>-{{ formatPrice($cart->discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">শিপিং</span>
                        <span>{{ formatPrice(60) }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between font-bold text-lg">
                        <span>মোট</span>
                        <span>{{ formatPrice($cart->total + 60) }}</span>
                    </div>
                </div>
                
                <!-- Coupon -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">কুপন কোড</label>
                    <div class="flex space-x-2">
                        <input type="text" id="couponCode" placeholder="কুপন কোড লিখুন" class="input-field flex-1">
                        <button onclick="applyCoupon()" class="btn-outline">প্রয়োগ করুন</button>
                    </div>
                </div>
                
                <a href="{{ route('checkout') }}" class="block btn-primary text-center">চেকআউট করুন</a>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl p-12 shadow-sm text-center">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h2 class="text-xl font-bold text-gray-800 mb-2">আপনার কার্ট খালি</h2>
        <p class="text-gray-500 mb-6">কার্টে পণ্য যোগ করতে দোকানে যান</p>
        <a href="{{ route('shop') }}" class="btn-primary inline-block">দোকানে যান</a>
    </div>
    @endif
</div>

@push('scripts')
<script>
async function updateQty(itemId, qty) {
    if (qty < 1) return;
    try {
        const response = await fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ item_id: itemId, quantity: qty }),
        });
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
    }
}

async function removeItem(itemId) {
    if (!confirm('আপনি কি এই পণ্যটি সরাতে চান?')) return;
    try {
        const response = await fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ item_id: itemId }),
        });
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
    }
}

async function applyCoupon() {
    const code = document.getElementById('couponCode').value;
    try {
        const response = await fetch('/cart/coupon', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ coupon_code: code }),
        });
        const data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
    }
}
</script>
@endpush
@endsection
