<div class="lg:col-span-1">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="text-center mb-4 pb-4 border-b">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="text-2xl font-bold text-primary-600">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <p class="font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('account') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('account') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                ড্যাশবোর্ড
            </a>
            <a href="{{ route('account.profile') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('account.profile') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                প্রোফাইল
            </a>
            <a href="{{ route('account.orders') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('account.orders*') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                অর্ডারসমূহ
            </a>
            <a href="{{ route('account.wishlist') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('account.wishlist') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                উইশলিস্ট
            </a>
            <a href="{{ route('account.addresses') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('account.addresses*') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                ঠিকানাসমূহ
            </a>
            <div class="border-t pt-1 mt-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        লগআউট
                    </button>
                </form>
            </div>
        </nav>
    </div>
</div>
