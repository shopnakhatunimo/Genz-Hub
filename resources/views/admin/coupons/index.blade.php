@extends('layouts.admin.app')

@section('title', 'কুপনসমূহ')
@section('header', 'কুপনসমূহ')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.coupons.create') }}" class="btn-primary">নতুন কুপন যোগ করুন</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">কোড</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">নাম</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ধরন</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">মান</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">মেয়াদ</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($coupons as $coupon)
            <tr>
                <td class="px-6 py-4 font-mono font-bold text-primary-600">{{ $coupon->code }}</td>
                <td class="px-6 py-4">{{ $coupon->name }}</td>
                <td class="px-6 py-4">{{ $coupon->type === 'fixed' ? 'নির্দিষ্ট' : 'শতাংশ' }}</td>
                <td class="px-6 py-4">{{ $coupon->type === 'fixed' ? formatPrice($coupon->value) : $coupon->value . '%' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'সীমাহীন' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $coupon->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $coupon->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">সম্পাদনা</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">কোনো কুপন নেই</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
