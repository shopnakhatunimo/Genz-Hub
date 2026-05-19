@extends('layouts.admin.app')

@section('title', 'সোশ্যাল মিডিয়া সেটিংস')
@section('header', 'সোশ্যাল মিডিয়া সেটিংস')

@section('content')
<form action="{{ route('admin.settings.social.update') }}" method="POST">
    @csrf
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl p-6 shadow-sm space-y-5">

            {{-- Facebook --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </span>
                    ফেসবুক পেজ লিংক
                </label>
                <input type="url" name="facebook" value="{{ getSetting('facebook') }}" placeholder="https://facebook.com/yourpage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            {{-- Instagram --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-pink-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path fill="white" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5a1.5 1.5 0 11-1.5-1.5 1.5 1.5 0 011.5 1.5z"/></svg>
                    </span>
                    ইন্সটাগ্রাম প্রোফাইল লিংক
                </label>
                <input type="url" name="instagram" value="{{ getSetting('instagram') }}" placeholder="https://instagram.com/yourprofile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            {{-- Twitter/X --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-gray-900 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </span>
                    টুইটার / X প্রোফাইল লিংক
                </label>
                <input type="url" name="twitter" value="{{ getSetting('twitter') }}" placeholder="https://x.com/yourprofile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            {{-- YouTube --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-red-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon fill="white" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                    </span>
                    ইউটিউব চ্যানেল লিংক
                </label>
                <input type="url" name="youtube" value="{{ getSetting('youtube') }}" placeholder="https://youtube.com/yourchannel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.555 4.126 1.524 5.868L.058 23.207a.5.5 0 00.61.637l5.515-1.442A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.811 9.811 0 01-5.032-1.381l-.36-.214-3.733.977.998-3.645-.235-.375A9.818 9.818 0 0112 2.182c5.42 0 9.818 4.398 9.818 9.818S17.42 21.818 12 21.818z"/></svg>
                    </span>
                    হোয়াটসঅ্যাপ নম্বর
                </label>
                <input type="text" name="whatsapp" value="{{ getSetting('whatsapp') }}" placeholder="+8801XXXXXXXXX" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            {{-- TikTok --}}
            <div>
                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 bg-gray-800 rounded-full flex items-center justify-center text-white text-xs font-bold">TT</span>
                    টিকটক প্রোফাইল লিংক
                </label>
                <input type="url" name="tiktok" value="{{ getSetting('tiktok') }}" placeholder="https://tiktok.com/@yourprofile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    সংরক্ষণ করুন
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
