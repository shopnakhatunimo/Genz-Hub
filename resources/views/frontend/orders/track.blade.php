@extends('layouts.frontend.app')

@section('title', 'অর্ডার ট্র্যাক')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">অর্ডার ট্র্যাকিং - #{{ $order->order_number }}</h1>
        <div class="bg-white rounded-xl shadow-sm p-6">
            @php
            $statuses = ['pending' => 'অপেক্ষমাণ', 'confirmed' => 'নিশ্চিত', 'processing' => 'প্রক্রিয়াধীন', 'shipped' => 'শিপড', 'delivered' => 'ডেলিভারড'];
            $currentIndex = array_search($order->order_status, array_keys($statuses));
            @endphp
            <div class="space-y-4">
                @foreach($statuses as $status => $label)
                @php $statusIndex = array_search($status, array_keys($statuses)); @endphp
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $statusIndex <= $currentIndex ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if($statusIndex < $currentIndex)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                        {{ $statusIndex + 1 }}
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="font-medium {{ $statusIndex === $currentIndex ? 'text-primary-600' : '' }}">{{ $label }}</p>
                        @if($statusIndex === $currentIndex)
                        <p class="text-xs text-gray-500">বর্তমান স্ট্যাটাস</p>
                        @endif
                    </div>
                </div>
                @if(!$loop->last)
                <div class="ml-4 w-px h-4 {{ $statusIndex < $currentIndex ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
