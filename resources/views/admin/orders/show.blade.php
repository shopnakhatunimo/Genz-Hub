@extends('layouts.admin.app')

@section('title', 'অর্ডার বিবরণ')
@section('header', 'অর্ডার #{{ $order->order_number }}')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">পণ্যসমূহ</h2>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        @if($item->product)
                        <img src="{{ $item->product->primaryImageUrl }}" alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded">
                        @endif
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ formatPrice($item->price) }}</p>
                        </div>
                    </div>
                    <p class="font-bold">{{ formatPrice($item->subtotal) }}</p>
                </div>
                @endforeach
            </div>
            <div class="border-t mt-4 pt-4 space-y-2">
                <div class="flex justify-between"><span>সাবটোটাল</span><span>{{ formatPrice($order->subtotal) }}</span></div>
                <div class="flex justify-between"><span>ডেলিভারি চার্জ</span><span>{{ formatPrice($order->shipping_charge) }}</span></div>
                @if($order->discount > 0)
                <div class="flex justify-between text-green-600"><span>ডিসকাউন্ট</span><span>-{{ formatPrice($order->discount) }}</span></div>
                @endif
                <div class="flex justify-between font-bold text-lg border-t pt-2"><span>মোট</span><span>{{ formatPrice($order->total) }}</span></div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">স্ট্যাটাস আপডেট</h2>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-3">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium mb-1">অর্ডার স্ট্যাটাস</label>
                    <select name="order_status" class="input-field">
                        @foreach(['pending' => 'অপেক্ষমাণ', 'confirmed' => 'নিশ্চিত', 'processing' => 'প্রক্রিয়াধীন', 'shipped' => 'শিপড', 'delivered' => 'ডেলিভারড', 'cancelled' => 'বাতিল'] as $val => $label)
                        <option value="{{ $val }}" {{ $order->order_status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">পেমেন্ট স্ট্যাটাস</label>
                    <select name="payment_status" class="input-field">
                        @foreach(['pending' => 'অপেক্ষমাণ', 'paid' => 'পরিশোধিত', 'failed' => 'ব্যর্থ', 'refunded' => 'ফেরত'] as $val => $label)
                        <option value="{{ $val }}" {{ $order->payment_status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full">আপডেট করুন</button>
            </form>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">গ্রাহকের তথ্য</h2>
            <div class="space-y-2 text-sm">
                <p><span class="text-gray-500">নাম:</span> {{ $order->name }}</p>
                <p><span class="text-gray-500">ইমেইল:</span> {{ $order->email }}</p>
                <p><span class="text-gray-500">ফোন:</span> {{ $order->phone }}</p>
                <p><span class="text-gray-500">ঠিকানা:</span> {{ $order->address }}, {{ $order->city }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
