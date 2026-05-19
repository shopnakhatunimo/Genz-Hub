@extends('layouts.admin.app')

@section('title', 'কুপন সম্পাদনা')
@section('header', 'কুপন সম্পাদনা')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">কোড *</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="input-field uppercase" required>
                    @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">নাম *</label>
                    <input type="text" name="name" value="{{ old('name', $coupon->name) }}" class="input-field" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">বিবরণ</label>
                <textarea name="description" class="input-field" rows="2">{{ old('description', $coupon->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ধরন *</label>
                    <select name="type" class="input-field" required>
                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>নির্দিষ্ট পরিমাণ (৳)</option>
                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>শতাংশ (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">মান *</label>
                    <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" class="input-field" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">শুরুর তারিখ</label>
                    <input type="date" name="starts_at" value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d')) }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">শেষের তারিখ</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}" class="input-field">
                </div>
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ $coupon->status ? 'checked' : '' }} class="mr-2"> সক্রিয়
                </label>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">আপডেট করুন</button>
                <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
