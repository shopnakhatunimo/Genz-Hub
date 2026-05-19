@extends('layouts.admin.app')

@section('title', 'নতুন ব্যানার')
@section('header', 'নতুন ব্যানার যোগ করুন')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">শিরোনাম *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="input-field" required>
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">সাবটাইটেল</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">ব্যানার ছবি *</label>
                <input type="file" name="image" accept="image/*" class="input-field" required>
                @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">লিঙ্ক (URL)</label>
                <input type="url" name="link" value="{{ old('link') }}" class="input-field" placeholder="https://...">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ধরন *</label>
                    <select name="type" class="input-field" required>
                        <option value="hero" {{ old('type') === 'hero' ? 'selected' : '' }}>Hero</option>
                        <option value="promo" {{ old('type') === 'promo' ? 'selected' : '' }}>Promo</option>
                        <option value="category" {{ old('type') === 'category' ? 'selected' : '' }}>Category</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">ক্রম</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="input-field">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">শুরুর তারিখ</label>
                    <input type="date" name="starts_at" value="{{ old('starts_at') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">শেষের তারিখ</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="input-field">
                </div>
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="mr-2"> সক্রিয়
                </label>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
