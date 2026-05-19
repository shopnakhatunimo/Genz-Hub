@extends('layouts.admin.app')

@section('title', 'ড্যাশবোর্ড')
@section('header', 'ড্যাশবোর্ড')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">মোট অর্ডার</p>
                <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">মোট বিক্রি</p>
                <h3 class="text-2xl font-bold">{{ formatPrice($totalRevenue) }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">মোট পণ্য</p>
                <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">মোট ইউজার</p>
                <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-bold mb-4">সাম্প্রতিক অর্ডার</h2>
        <div class="space-y-4">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium">{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">{{ $order->name }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">{{ formatPrice($order->total) }}</p>
                    <p class="text-sm text-{{ $order->status === 'completed' ? 'green' : 'blue' }}-600">{{ $order->status_label }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-bold mb-4">জনপ্রিয় পণ্য</h2>
        <div class="space-y-4">
            @foreach($topProducts as $product)
            <div class="flex items-center space-x-3">
                <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                <div class="flex-1">
                    <p class="font-medium">{{ $product->name }}</p>
                    <p class="text-sm text-gray-500">{{ $product->sold_count }} বিক্রি</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
