@extends('layouts.admin.app')

@section('title', 'SEO সেটিংস')
@section('header', 'SEO সেটিংস')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.settings.seo.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Meta Title</label>
                <input type="text" name="meta_title" value="{{ getSetting('meta_title') }}" class="input-field" maxlength="60">
                <p class="text-xs text-gray-400 mt-1">সর্বোচ্চ ৬০ অক্ষর</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Meta Description</label>
                <textarea name="meta_description" class="input-field" rows="3" maxlength="160">{{ getSetting('meta_description') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">সর্বোচ্চ ১৬০ অক্ষর</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ getSetting('meta_keywords') }}" class="input-field" placeholder="কমা দিয়ে আলাদা করুন">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Google Analytics ID</label>
                <input type="text" name="google_analytics" value="{{ getSetting('google_analytics') }}" class="input-field" placeholder="G-XXXXXXXXXX">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Facebook Pixel ID</label>
                <input type="text" name="facebook_pixel" value="{{ getSetting('facebook_pixel') }}" class="input-field" placeholder="XXXXXXXXXXXXXXXX">
            </div>
            <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
        </form>
    </div>
</div>
@endsection
