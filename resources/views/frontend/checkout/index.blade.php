@extends('layouts.frontend.app')

@section('title', 'চেকআউট')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">চেকআউট</h1>
    
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold mb-4">শিপিং ঠিকানা</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">নাম *</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">ফোন *</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" required class="input-field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">ঠিকানা *</label>
                            <textarea name="address" required class="input-field" rows="3">{{ $defaultAddress->address ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">শহর *</label>
                            <input type="text" name="city" value="{{ $defaultAddress->city ?? '' }}" required class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">এলাকা *</label>
                            <input type="text" name="area" value="{{ $defaultAddress->area ?? '' }}" required class="input-field">
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold mb-4">পেমেন্ট পদ্ধতি</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-primary-500">
                            <input type="radio" name="payment_method" value="cod" checked class="mr-3">
                            <div>
                                <span class="font-medium">ক্যাশ অন ডেলিভারি</span>
                                <p class="text-sm text-gray-500">ডেলিভারির সময় নগদ পেমেন্ট করুন</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-primary-500">
                            <input type="radio" name="payment_method" value="online" class="mr-3">
                            <div>
                                <span class="font-medium">অনলাইন পেমেন্ট</span>
                                <p class="text-sm text-gray-500">বিকাশ, নগদ বা কার্ড দিয়ে পেমেন্ট করুন</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Order Notes -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold mb-4">অর্ডার নোট</h2>
                    <textarea name="notes" class="input-field" rows="3" placeholder="যেকোনো অতিরিক্ত নির্দেশনা লিখুন..."></textarea>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-xl p-6 shadow-sm sticky top-20">
                    <h2 class="text-lg font-bold mb-4">অর্ডার সারাংশ</h2>
                    
                    <div class="space-y-3 mb-6">
                        @foreach($cart->items as $item)
                        <div class="flex items-center space-x-3">
                            <img src="{{ $item->product->primaryImageUrl }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-medium text-sm">{{ $item->product->name }}</h4>
                                <p class="text-gray-500 text-sm">{{ $item->quantity }} x {{ formatPrice($item->price) }}</p>
                            </div>
                            <span class="font-medium">{{ formatPrice($item->subtotal) }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t pt-4 space-y-3 mb-6">
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
                    
                    <button type="submit" class="w-full btn-primary">অর্ডার সম্পন্ন করুন</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
