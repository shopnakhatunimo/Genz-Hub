<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', getSiteName()) - E-Commerce</title>
    
    @if(getSetting('meta_description'))
    <meta name="description" content="{{ getSetting('meta_description') }}">
    @endif
    
    @if(getSetting('meta_keywords'))
    <meta name="keywords" content="{{ getSetting('meta_keywords') }}">
    @endif
    
    <link rel="icon" href="{{ getFavicon() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    
    <!-- Mobile Header -->
    <header class="lg:hidden fixed top-0 left-0 right-0 bg-white shadow-sm z-40">
        <div class="flex items-center justify-between px-4 py-3">
            <button @click="$store.mobileMenu = true" class="p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-8">
            </a>
            <a href="{{ auth()->check() ? route('cart') : route('login') }}" class="relative p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                @if(cartCount() > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ cartCount() }}</span>
                @endif
            </a>
        </div>
    </header>

    <!-- Desktop Header -->
    <header class="hidden lg:block fixed top-0 left-0 right-0 bg-white shadow-sm z-40">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-10">
                </a>
                
                <nav class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 font-medium">হোম</a>
                    <a href="{{ route('shop') }}" class="text-gray-700 hover:text-primary-600 font-medium">দোকান</a>
                    <a href="{{ route('categories') }}" class="text-gray-700 hover:text-primary-600 font-medium">ক্যাটাগরি</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-600 font-medium">যোগাযোগ</a>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="অনুসন্ধান..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    @auth
                    <a href="{{ route('account') }}" class="text-gray-700 hover:text-primary-600 font-medium">অ্যাকাউন্ট</a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 font-medium">লগইন</a>
                    @endif
                    
                    <a href="{{ auth()->check() ? route('cart') : route('login') }}" class="relative p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @if(cartCount() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ cartCount() }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div x-data="{ mobileMenu: false }" x-show="mobileMenu" class="lg:hidden fixed inset-0 bg-black/50 z-50" x-transition>
        <div class="fixed left-0 top-0 bottom-0 w-64 bg-white shadow-xl">
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-8">
                    <button @click="mobileMenu = false" class="p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <nav class="p-4">
                <a href="{{ route('home') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">হোম</a>
                <a href="{{ route('shop') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">দোকান</a>
                <a href="{{ route('categories') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">ক্যাটাগরি</a>
                <a href="{{ route('contact') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">যোগাযোগ</a>
                @auth
                <a href="{{ route('account') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">অ্যাকাউন্ট</a>
                @else
                <a href="{{ route('login') }}" class="block py-3 text-gray-700 hover:text-primary-600 font-medium border-b">লগইন</a>
                @endauth
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="pt-16 lg:pt-16 pb-20 lg:pb-0">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg z-40">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('home') ? 'text-primary-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs mt-1">হোম</span>
            </a>
            <a href="{{ route('shop') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('shop*') ? 'text-primary-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs mt-1">দোকান</span>
            </a>
            <a href="{{ auth()->check() ? route('cart') : route('login') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('cart*') ? 'text-primary-600' : 'text-gray-500' }}">
                <div class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @if(cartCount() > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center">{{ cartCount() }}</span>
                    @endif
                </div>
                <span class="text-xs mt-1">কার্ট</span>
            </a>
            <a href="{{ auth()->check() ? route('account') : route('login') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('account*') ? 'text-primary-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs mt-1">অ্যাকাউন্ট</span>
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-10 mb-4">
                    <p class="text-gray-400">{{ getSetting('site_address') }}</p>
                    <p class="text-gray-400 mt-2">{{ getSetting('site_phone') }}</p>
                    <p class="text-gray-400">{{ getSetting('site_email') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">দ্রুত লিংক</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">হোম</a></li>
                        <li><a href="{{ route('shop') }}" class="text-gray-400 hover:text-white">দোকান</a></li>
                        <li><a href="{{ route('categories') }}" class="text-gray-400 hover:text-white">ক্যাটাগরি</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">যোগাযোগ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">কাস্টমার সার্ভিস</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">অর্ডার ট্র্যাকিং</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">রিটার্ন পলিসি</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">শিপিং তথ্য</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">নিউজলেটার</h3>
                    <form action="{{ route('newsletter') }}" method="POST" class="flex">
                        @csrf
                        <input type="email" name="email" placeholder="আপনার ইমেইল" class="flex-1 px-4 py-2 rounded-l-lg text-gray-800 outline-none" required>
                        <button type="submit" class="bg-primary-600 px-4 py-2 rounded-r-lg hover:bg-primary-700">সাবস্ক্রাইব</button>
                    </form>
                    <div class="flex space-x-4 mt-4">
                        @if(getSetting('facebook'))
                        <a href="{{ getSetting('facebook') }}" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if(getSetting('instagram'))
                        <a href="{{ getSetting('instagram') }}" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ getSiteName() }}. সর্বস্বত্ব সংরক্ষিত।</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
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
    
    @if(session('warning'))
    <script>
        showToast('{{ session('warning') }}', 'warning');
    </script>
    @endif
</body>
</html>
