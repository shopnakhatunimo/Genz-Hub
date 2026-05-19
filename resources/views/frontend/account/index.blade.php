@extends('layouts.frontend.app')

@section('title', 'আমার অ্যাকাউন্ট')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">অ্যাকাউন্ট ওভারভিউ</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $orders->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">সাম্প্রতিক অর্ডার</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <a href="{{ route('account.wishlist') }}" class="text-3xl font-bold text-green-600 hover:underline">দেখুন</a>
                        <div class="text-sm text-gray-600 mt-1">উইশলিস্ট</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <a href="{{ route('account.addresses') }}" class="text-3xl font-bold text-purple-600 hover:underline">দেখুন</a>
                        <div class="text-sm text-gray-600 mt-1">ঠিকানা</div>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">ব্যক্তিগত তথ্য</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-500">নাম</p><p class="font-medium">{{ $user->name }}</p></div>
                        <div><p class="text-gray-500">ইমেইল</p><p class="font-medium">{{ $user->email }}</p></div>
                        <div><p class="text-gray-500">ফোন</p><p class="font-medium">{{ $user->phone ?? 'যোগ করুন' }}</p></div>
                        <div><p class="text-gray-500">যোগদান</p><p class="font-medium">{{ $user->created_at->format('d M Y') }}</p></div>
                    </div>
                </div>
                @if($orders->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold mb-4">সাম্প্রতিক অর্ডারসমূহ</h3>
                    <div class="space-y-3">
                        @foreach($orders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">{{ formatPrice($order->total) }}</p>
                                <a href="{{ route('order.show', $order->order_number) }}" class="text-primary-600 text-xs hover:underline">বিবরণ</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
