@extends('layouts.admin.app')

@section('title', 'ব্যানারসমূহ')
@section('header', 'ব্যানারসমূহ')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.banners.create') }}" class="btn-primary">নতুন ব্যানার যোগ করুন</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($banners as $banner)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-40 object-cover">
        <div class="p-4">
            <h3 class="font-semibold">{{ $banner->title }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $banner->subtitle }}</p>
            <div class="flex items-center justify-between mt-3">
                <span class="px-2 py-1 text-xs rounded {{ $banner->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $banner->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                </span>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">সম্পাদনা</a>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-gray-500">কোনো ব্যানার নেই</div>
    @endforelse
</div>
@endsection
