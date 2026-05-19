@extends('layouts.admin.app')

@section('title', 'ব্যানার সম্পাদনা')
@section('header', 'ব্যানার সম্পাদনা')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">শিরোনাম *</label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="input-field" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">সাবটাইটেল</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">ছবি পরিবর্তন করুন</label>
                <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}" class="h-24 mb-2 rounded object-cover">
                <input type="file" name="image" accept="image/*" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">লিঙ্ক (URL)</label>
                <input type="url" name="link" value="{{ old('link', $banner->link) }}" class="input-field" placeholder="https://...">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ধরন *</label>
                    <select name="type" class="input-field" required>
                        @foreach(['hero' => 'Hero', 'promo' => 'Promo', 'category' => 'Category'] as $val => $label)
                        <option value="{{ $val }}" {{ $banner->type === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">ক্রম</label>
                    <input type="number" name="order" value="{{ old('order', $banner->order) }}" class="input-field">
                </div>
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ $banner->status ? 'checked' : '' }} class="mr-2"> সক্রিয়
                </label>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">আপডেট করুন</button>
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
