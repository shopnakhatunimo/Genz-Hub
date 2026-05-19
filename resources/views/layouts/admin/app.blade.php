<!DOCTYPE html>
<html lang="bn" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ getSiteName() }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-full">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition class="lg:hidden fixed inset-0 bg-black/50 z-40" @click="sidebarOpen = false"></div>
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="lg:translate-x-0 fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">{{ getSiteName() }}</a>
                <button @click="sidebarOpen = false" class="lg:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-4rem)]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.dashboard', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    ড্যাশবোর্ড
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">পণ্য ম্যানেজমেন্ট</div>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.products*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    পণ্যসমূহ
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.categories*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    ক্যাটাগরি
                </a>
                
                <a href="{{ route('admin.subcategories.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.subcategories*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    সাবক্যাটাগরি
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">অর্ডার ম্যানেজমেন্ট</div>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.orders*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    অর্ডারসমূহ
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">মার্কেটিং</div>
                
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.coupons*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    কুপন
                </a>
                
                <a href="{{ route('admin.banners.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.banners*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    ব্যানার
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">ইউজার ম্যানেজমেন্ট</div>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.users*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    ইউজার
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ isActiveRoute('admin.reviews*', 'active', 'hover:bg-gray-800') }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    রিভিউ
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">সেটিংস</div>

                <a href="{{ route('admin.settings.general') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.general') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    সাধারণ সেটিংস
                </a>

                <a href="{{ route('admin.settings.smtp') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.smtp') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    SMTP মেইল
                </a>

                <a href="{{ route('admin.settings.seo') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.seo') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    SEO সেটিংস
                </a>

                <a href="{{ route('admin.settings.social') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.social') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    সোশ্যাল মিডিয়া
                </a>

                <a href="{{ route('admin.settings.payment') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.payment') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    পেমেন্ট সেটিংস
                </a>

                <a href="{{ route('admin.settings.maintenance') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.settings.maintenance') ? 'bg-gray-700 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    মেইনটেন্যান্স মোড
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
                <button @click="sidebarOpen = true" class="lg:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'ড্যাশবোর্ড')</h1>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    
                    <div class="relative">
                        <button @click="$store.dropdown = !$store.dropdown" class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ optional(auth()->guard('admin')->user())->name ? mb_substr(auth()->guard('admin')->user()->name, 0, 1) : 'A' }}
                            </div>
                        </button>
                        
                        <div x-show="$store.dropdown" @click.away="$store.dropdown = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">প্রোফাইল</a>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">লগআউট</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    @if(session('success'))
    <script>
        showToast('{{ session('success') }}', 'success');
    </script>
    @endif
    
    @if(session('error'))
    <script>
        showToast('{{ session('error') }}', 'error');
    </script>
    @endif

    @stack('scripts')
</body>
</html>
