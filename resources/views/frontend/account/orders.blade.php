@extends('layouts.frontend.app')

@section('title', 'আমার অর্ডারসমূহ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">আমার অর্ডারসমূহ</h2>
                @forelse($orders as $order)
                <div class="border rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="font-semibold">অর্ডার #{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">{{ formatPrice($order->total) }}</p>
                            <span class="text-xs px-2 py-1 rounded {{ $order->order_status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $order->order_status }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex space-x-2">
                            @foreach($order->items->take(3) as $item)
                            <div class="text-xs text-gray-600">{{ $item->product_name }}</div>
                            @endforeach
                            @if($order->items->count() > 3)
                            <div class="text-xs text-gray-400">+{{ $order->items->count() - 3 }} আরো</div>
                            @endif
                        </div>
                        <a href="{{ route('order.show', $order->order_number) }}" class="text-primary-600 text-sm hover:underline">বিবরণ দেখুন</a>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <p class="text-gray-500">কোনো অর্ডার নেই</p>
                    <a href="{{ route('shop') }}" class="btn-primary mt-4 inline-block">কেনাকাটা শুরু করুন</a>
                </div>
                @endforelse
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
