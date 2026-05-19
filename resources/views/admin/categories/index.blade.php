@extends('layouts.admin.app')

@section('title', 'ক্যাটাগরিসমূহ')
@section('header', 'ক্যাটাগরিসমূহ')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">নতুন ক্যাটাগরি যোগ করুন</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ক্যাটাগরি</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">সাবক্যাটাগরি</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ক্রম</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        @if($category->image)
                        <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 object-cover rounded">
                        @else
                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">কোনো ছবি নেই</div>
                        @endif
                        <div>
                            <p class="font-medium">{{ $category->name }}</p>
                            <p class="text-xs text-gray-400">{{ $category->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $category->subcategories->count() }}</td>
                <td class="px-6 py-4">{{ $category->order }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $category->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">সম্পাদনা</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">কোনো ক্যাটাগরি নেই</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
