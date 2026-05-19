@extends('layouts.admin.app')

@section('title', 'সাবক্যাটাগরিসমূহ')
@section('header', 'সাবক্যাটাগরিসমূহ')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.subcategories.create') }}" class="btn-primary">নতুন সাবক্যাটাগরি যোগ করুন</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">নাম</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ক্যাটাগরি</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($subcategories as $sub)
            <tr>
                <td class="px-6 py-4 font-medium">{{ $sub->name }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $sub->category->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $sub->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $sub->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">সম্পাদনা</a>
                        <form action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">কোনো সাবক্যাটাগরি নেই</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
