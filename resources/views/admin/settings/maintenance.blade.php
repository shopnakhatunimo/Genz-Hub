@extends('layouts.admin.app')

@section('title', 'মেইনটেন্যান্স মোড')
@section('header', 'মেইনটেন্যান্স মোড')

@section('content')
<div class="max-w-2xl">

    {{-- Current Status --}}
    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
        <h2 class="text-lg font-semibold mb-4">বর্তমান অবস্থা</h2>
        @if($isDown)
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-lg">
            <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
            <div>
                <p class="font-semibold text-red-700">মেইনটেন্যান্স মোড চালু আছে</p>
                <p class="text-sm text-red-500">ওয়েবসাইট এখন ভিজিটরদের জন্য বন্ধ।</p>
            </div>
        </div>
        @else
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
            <div>
                <p class="font-semibold text-green-700">ওয়েবসাইট স্বাভাবিকভাবে চলছে</p>
                <p class="text-sm text-green-500">সকল ভিজিটর স্বাভাবিকভাবে সাইট দেখতে পাচ্ছেন।</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Toggle --}}
    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
        <h2 class="text-lg font-semibold mb-2">মেইনটেন্যান্স মোড {{ $isDown ? 'বন্ধ' : 'চালু' }} করুন</h2>
        <p class="text-sm text-gray-500 mb-5">
            মেইনটেন্যান্স মোড চালু করলে সাধারণ ভিজিটররা একটি "মেইনটেন্যান্স চলছে" পেজ দেখবেন। 
            অ্যাডমিন প্যানেল স্বাভাবিকভাবে কাজ করবে।
        </p>
        <form action="{{ route('admin.settings.maintenance.toggle') }}" method="POST">
            @csrf
            @if($isDown)
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                মেইনটেন্যান্স মোড বন্ধ করুন (সাইট চালু করুন)
            </button>
            @else
            <button type="submit" onclick="return confirm('আপনি কি নিশ্চিত? মেইনটেন্যান্স মোড চালু করলে সাইট ভিজিটরদের জন্য বন্ধ হয়ে যাবে।')"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                মেইনটেন্যান্স মোড চালু করুন (সাইট বন্ধ করুন)
            </button>
            @endif
        </form>
    </div>

    {{-- Maintenance Message --}}
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">মেইনটেন্যান্স বার্তা কাস্টমাইজ করুন</h2>
        <form action="{{ route('admin.settings.maintenance.message') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">শিরোনাম</label>
                    <input type="text" name="maintenance_title" value="{{ getSetting('maintenance_title', 'মেইনটেন্যান্স চলছে') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">বার্তা</label>
                    <textarea name="maintenance_message" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">{{ getSetting('maintenance_message', 'আমরা আমাদের সাইট আপডেট করছি। শীঘ্রই ফিরে আসছি।') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">ফিরে আসার সময় (ঐচ্ছিক)</label>
                    <input type="text" name="maintenance_eta" value="{{ getSetting('maintenance_eta') }}"
                        placeholder="যেমন: ২-৩ ঘণ্টার মধ্যে"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
