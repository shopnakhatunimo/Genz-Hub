@extends('layouts.admin.app')

@section('title', 'ব্যবহারকারীর বিবরণ')
@section('header', 'ব্যবহারকারীর বিবরণ')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">প্রোফাইল</h2>
            <div class="space-y-3">
                <div><p class="text-xs text-gray-500">নাম</p><p class="font-medium">{{ $user->name }}</p></div>
                <div><p class="text-xs text-gray-500">ইমেইল</p><p class="font-medium">{{ $user->email }}</p></div>
                <div><p class="text-xs text-gray-500">ফোন</p><p class="font-medium">{{ $user->phone ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">যোগদান</p><p class="font-medium">{{ $user->created_at->format('d M Y') }}</p></div>
            </div>
            <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" class="mt-4">
                @csrf @method('PUT')
                <label class="block text-sm font-medium mb-1">স্ট্যাটাস পরিবর্তন</label>
                <select name="status" class="input-field mb-2">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                    <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>ব্লক</option>
                </select>
                <button type="submit" class="btn-primary w-full">আপডেট করুন</button>
            </form>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">অর্ডারসমূহ</h2>
            @forelse($user->orders as $order)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg mb-2">
                <div>
                    <p class="font-medium">{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">{{ formatPrice($order->total) }}</p>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 text-sm">দেখুন</a>
                </div>
            </div>
            @empty
            <p class="text-gray-500">কোনো অর্ডার নেই</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
