@extends('layouts.admin.app')

@section('title', 'SMTP সেটিংস')
@section('header', 'SMTP সেটিংস')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">SMTP কনফিগারেশন</h2>
        <form action="{{ route('admin.settings.smtp.update') }}" method="POST" class="space-y-4">
            @csrf
            @if($smtp) <input type="hidden" name="id" value="{{ $smtp->id }}"> @endif
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">SMTP Host *</label>
                    <input type="text" name="host" value="{{ old('host', $smtp->host ?? '') }}" class="input-field" placeholder="smtp.gmail.com" required>
                    @error('host')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Port *</label>
                    <input type="text" name="port" value="{{ old('port', $smtp->port ?? '587') }}" class="input-field" placeholder="587" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Username *</label>
                    <input type="text" name="username" value="{{ old('username', $smtp->username ?? '') }}" class="input-field" required>
                    @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password *</label>
                    <input type="password" name="password" value="{{ old('password', $smtp->password ?? '') }}" class="input-field" required>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Encryption</label>
                    <select name="encryption" class="input-field">
                        <option value="tls" {{ ($smtp->encryption ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ ($smtp->encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="">কোনোটি নয়</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">From Name *</label>
                    <input type="text" name="from_name" value="{{ old('from_name', $smtp->from_name ?? getSetting('site_name')) }}" class="input-field" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">From Address *</label>
                <input type="email" name="from_address" value="{{ old('from_address', $smtp->from_address ?? '') }}" class="input-field" required>
                @error('from_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
        </form>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">টেস্ট ইমেইল</h2>
        <form action="{{ route('admin.settings.smtp.test') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="email" name="email" class="input-field flex-1" placeholder="টেস্ট ইমেইল ঠিকানা" required>
            <button type="submit" class="btn-primary">পাঠান</button>
        </form>
    </div>
</div>
@endsection
