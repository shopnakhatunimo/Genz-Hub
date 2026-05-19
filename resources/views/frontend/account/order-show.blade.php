@extends('layouts.frontend.app')

@section('title', 'অর্ডার বিবরণ - #{{ $order->order_number }}')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3 space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold">অর্ডার #{{ $order->order_number }}</h1>
                <a href="{{ route('account.orders') }}" class="text-primary-600 hover:underline text-sm">← অর্ডার তালিকায় ফিরুন</a>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                    <p class="text-xs text-gray-500">অর্ডার স্ট্যাটাস</p>
                    <p class="font-bold text-primary-600 mt-1">{{ $order->order_status }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                    <p class="text-xs text-gray-500">পেমেন্ট</p>
                    <p class="font-bold text-green-600 mt-1">{{ $order->payment_status }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                    <p class="text-xs text-gray-500">তারিখ</p>
                    <p class="font-bold mt-1">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="font-bold mb-4">পণ্যসমূহ</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 py-3 border-b last:border-0">
                        <div class="flex-1">
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ formatPrice($item->price) }}</p>
                        </div>
                        <p class="font-bold">{{ formatPrice($item->subtotal) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span>সাবটোটাল</span><span>{{ formatPrice($order->subtotal) }}</span></div>
                    <div class="flex justify-between"><span>ডেলিভারি চার্জ</span><span>{{ formatPrice($order->shipping_cost) }}</span></div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-green-600"><span>ডিসকাউন্ট</span><span>-{{ formatPrice($order->discount) }}</span></div>
                    @endif
                    <div class="flex justify-between font-bold text-base border-t pt-2"><span>সর্বমোট</span><span>{{ formatPrice($order->total) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
