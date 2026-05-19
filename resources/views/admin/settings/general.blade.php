@extends('layouts.admin.app')

@section('title', 'সাধারণ সেটিংস')
@section('header', 'সাধারণ সেটিংস')

@section('content')
<form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl p-6 shadow-sm space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">সাইটের নাম</label>
                <input type="text" name="site_name" value="{{ getSetting('site_name') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">লোগো</label>
                <input type="file" name="logo" class="input-field">
                @if(getSetting('logo'))
                <img src="{{ asset('uploads/' . getSetting('logo')) }}" alt="Logo" class="h-12 mt-2">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">ঠিকানা</label>
                <textarea name="site_address" class="input-field" rows="2">{{ getSetting('site_address') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">ফোন</label>
                <input type="text" name="site_phone" value="{{ getSetting('site_phone') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">ইমেইল</label>
                <input type="email" name="site_email" value="{{ getSetting('site_email') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Facebook</label>
                <input type="text" name="facebook" value="{{ getSetting('facebook') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Instagram</label>
                <input type="text" name="instagram" value="{{ getSetting('instagram') }}" class="input-field">
            </div>
            <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
        </div>
    </div>
</form>
@endsection
