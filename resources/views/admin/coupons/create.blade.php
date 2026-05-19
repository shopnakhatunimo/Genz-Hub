@extends('layouts.admin.app')

@section('title', 'নতুন কুপন')
@section('header', 'নতুন কুপন যোগ করুন')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">কোড *</label>
                    <input type="text" name="code" value="{{ old('code') }}" class="input-field uppercase" required>
                    @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">নাম *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">বিবরণ</label>
                <textarea name="description" class="input-field" rows="2">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ধরন *</label>
                    <select name="type" class="input-field" required>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>নির্দিষ্ট পরিমাণ (৳)</option>
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>শতাংশ (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">মান *</label>
                    <input type="number" name="value" value="{{ old('value') }}" step="0.01" class="input-field" required>
                    @error('value')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ন্যূনতম অর্ডার মূল্য</label>
                    <input type="number" name="min_order_amount" value="{{ old('min_order_amount', 0) }}" step="0.01" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">সর্বোচ্চ ডিসকাউন্ট</label>
                    <input type="number" name="max_discount" value="{{ old('max_discount') }}" step="0.01" class="input-field">
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
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ব্যবহারের সীমা</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="input-field" placeholder="খালি = সীমাহীন">
                </div>
                <div class="flex items-center mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="mr-2"> সক্রিয়
                    </label>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
                <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
