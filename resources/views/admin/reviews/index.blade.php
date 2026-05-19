@extends('layouts.admin.app')

@section('title', 'রিভিউসমূহ')
@section('header', 'রিভিউসমূহ')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="mb-4">
    <form method="GET" class="flex gap-4">
        <select name="status" class="input-field max-w-xs">
            <option value="">সব রিভিউ</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>অনুমোদিত</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>অপেক্ষমাণ</option>
        </select>
        <button type="submit" class="btn-primary">ফিল্টার</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ব্যবহারকারী</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">পণ্য</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">রেটিং</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">মন্তব্য</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($reviews as $review)
            <tr>
                <td class="px-6 py-4">{{ $review->user->name ?? 'অজ্ঞাত' }}</td>
                <td class="px-6 py-4">{{ $review->product->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $review->comment }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $review->is_approved ? 'অনুমোদিত' : 'অপেক্ষমাণ' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        @if(!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm">অনুমোদন</button>
                        </form>
                        @else
                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">প্রত্যাখ্যান</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">কোনো রিভিউ নেই</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $reviews->links() }}</div>
</div>
@endsection
