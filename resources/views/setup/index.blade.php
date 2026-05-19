<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ইন্সটলেশন উইজার্ড</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Hind Siliguri', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #7c3aed 100%); }
        .step-line { transition: width 0.5s ease; }
        .input-field { @apply w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm; }
        .btn-primary { @apply bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition flex items-center justify-center gap-2; }
        .btn-secondary { @apply bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-xl transition; }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">

<div x-data="wizard()" class="w-full max-w-2xl">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur rounded-2xl mb-4">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">ই-কমার্স ইন্সটলার</h1>
        <p class="text-blue-200 mt-1 text-sm">আপনার দোকান সেটআপ করুন মাত্র কয়েক মিনিটে</p>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center justify-center gap-2 mb-6">
        <template x-for="(step, i) in steps" :key="i">
            <div class="flex items-center gap-2">
                <div class="flex flex-col items-center">
                    <div :class="currentStep > i ? 'bg-green-400 text-white' : (currentStep === i ? 'bg-white text-blue-700 ring-4 ring-white/30' : 'bg-white/20 text-white/60')"
                         class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300">
                        <template x-if="currentStep > i">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <template x-if="currentStep <= i">
                            <span x-text="i + 1"></span>
                        </template>
                    </div>
                    <span class="text-xs mt-1 hidden sm:block" :class="currentStep === i ? 'text-white font-medium' : 'text-white/50'" x-text="step"></span>
                </div>
                <div x-show="i < steps.length - 1" class="w-8 sm:w-12 h-0.5 mb-4" :class="currentStep > i ? 'bg-green-400' : 'bg-white/20'"></div>
            </div>
        </template>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

        {{-- ধাপ ০: সিস্টেম যাচাই --}}
        <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">স্বাগতম! 👋</h2>
                <p class="text-gray-500 text-sm mb-6">ইন্সটলেশন শুরু করার আগে সিস্টেম যাচাই করা হচ্ছে।</p>

                <div class="space-y-3">
                    @foreach($requirements['checks'] as $check)
                    <div class="flex items-center justify-between p-3 rounded-xl {{ $check['pass'] ? 'bg-green-50' : 'bg-red-50' }}">
                        <div class="flex items-center gap-3">
                            @if($check['pass'])
                            <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            @else
                            <div class="w-7 h-7 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            @endif
                            <span class="text-sm font-medium {{ $check['pass'] ? 'text-green-800' : 'text-red-800' }}">{{ $check['label'] }}</span>
                        </div>
                        <span class="text-xs {{ $check['pass'] ? 'text-green-600' : 'text-red-600' }} font-medium">{{ $check['value'] }}</span>
                    </div>
                    @endforeach
                </div>

                @if(!$requirements['allPassed'])
                <div class="mt-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-red-700 text-sm font-medium">⚠️ কিছু requirements পূরণ হয়নি। সার্ভার অ্যাডমিনের সাথে যোগাযোগ করুন।</p>
                </div>
                @endif
            </div>
            <div class="px-8 pb-8 flex justify-end">
                <button @click="nextStep()" {{ !$requirements['allPassed'] ? 'disabled' : '' }}
                    class="btn-primary {{ !$requirements['allPassed'] ? 'opacity-50 cursor-not-allowed' : '' }}">
                    পরবর্তী ধাপ
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- ধাপ ১: ডাটাবেস সংযোগ --}}
        <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">ডাটাবেস সংযোগ 🗄️</h2>
                <p class="text-gray-500 text-sm mb-6">আপনার ডাটাবেসের তথ্য দিন।</p>

                {{-- DB Type Selector --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ডাটাবেস ধরন</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label :class="form.db_connection === 'mysql' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                               class="border-2 rounded-xl p-3 text-center cursor-pointer transition hover:border-blue-300">
                            <input type="radio" x-model="form.db_connection" value="mysql" class="hidden">
                            <div class="text-2xl mb-1">🐬</div>
                            <div class="text-sm font-semibold">MySQL</div>
                            <div class="text-xs opacity-70">PlanetScale</div>
                        </label>
                        <label :class="form.db_connection === 'pgsql' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                               class="border-2 rounded-xl p-3 text-center cursor-pointer transition hover:border-blue-300">
                            <input type="radio" x-model="form.db_connection" value="pgsql" class="hidden">
                            <div class="text-2xl mb-1">🐘</div>
                            <div class="text-sm font-semibold">PostgreSQL</div>
                            <div class="text-xs opacity-70">Render DB</div>
                        </label>
                        <label :class="form.db_connection === 'sqlite' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-600'"
                               class="border-2 rounded-xl p-3 text-center cursor-pointer transition hover:border-blue-300">
                            <input type="radio" x-model="form.db_connection" value="sqlite" class="hidden">
                            <div class="text-2xl mb-1">📁</div>
                            <div class="text-sm font-semibold">SQLite</div>
                            <div class="text-xs opacity-70">কোনো setup নেই</div>
                        </label>
                    </div>
                </div>

                {{-- SQLite Note --}}
                <div x-show="form.db_connection === 'sqlite'" class="mb-5 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <p class="text-blue-700 text-sm">✅ SQLite-এ কোনো ডাটাবেস সার্ভার লাগবে না। ফাইল হিসেবে সংরক্ষিত হবে। ছোট ও মাঝারি সাইটের জন্য উপযুক্ত।</p>
                </div>

                {{-- MySQL/PostgreSQL fields --}}
                <div x-show="form.db_connection !== 'sqlite'" class="space-y-4">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">হোস্ট</label>
                            <input type="text" x-model="form.db_host" placeholder="127.0.0.1" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">পোর্ট</label>
                            <input type="text" x-model="form.db_port" placeholder="3306" class="input-field">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">ডাটাবেস নাম</label>
                        <input type="text" x-model="form.db_database" placeholder="ecommerce" class="input-field">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">ইউজারনেম</label>
                            <input type="text" x-model="form.db_username" placeholder="root" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">পাসওয়ার্ড</label>
                            <input type="password" x-model="form.db_password" placeholder="••••••••" class="input-field">
                        </div>
                    </div>
                </div>

                {{-- Test connection result --}}
                <div x-show="dbTestResult" class="mt-4">
                    <div :class="dbTestResult === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700'"
                         class="border rounded-xl p-3 text-sm flex items-center gap-2">
                        <span x-text="dbTestResult === 'success' ? '✅ সংযোগ সফল!' : '❌ ' + dbTestError"></span>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8 flex justify-between items-center">
                <button @click="prevStep()" class="btn-secondary">পিছনে</button>
                <div class="flex gap-3">
                    <button @click="testDbConnection()" :disabled="dbTesting"
                        class="border border-blue-500 text-blue-600 hover:bg-blue-50 px-5 py-2.5 rounded-xl text-sm font-medium transition flex items-center gap-2">
                        <svg x-show="dbTesting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <span x-text="dbTesting ? 'পরীক্ষা হচ্ছে...' : 'সংযোগ পরীক্ষা করুন'"></span>
                    </button>
                    <button @click="nextStep()" class="btn-primary">
                        পরবর্তী
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ধাপ ২: সাইট সেটিংস --}}
        <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">সাইটের তথ্য 🏪</h2>
                <p class="text-gray-500 text-sm mb-6">আপনার দোকানের মূল তথ্য দিন।</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">দোকানের নাম <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.app_name" placeholder="আমার দোকান" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">সাইটের URL <span class="text-red-500">*</span></label>
                        <input type="url" x-model="form.app_url" placeholder="https://myshop.onrender.com" class="input-field">
                        <p class="text-xs text-gray-400 mt-1">Render-এ deploy করলে আপনার app URL দিন।</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">মুদ্রা চিহ্ন</label>
                        <select x-model="form.currency" class="input-field">
                            <option value="৳">৳ — বাংলাদেশি টাকা (BDT)</option>
                            <option value="$">$ — US Dollar</option>
                            <option value="€">€ — Euro</option>
                            <option value="£">£ — British Pound</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-8 pb-8 flex justify-between">
                <button @click="prevStep()" class="btn-secondary">পিছনে</button>
                <button @click="validateSiteStep()" class="btn-primary">
                    পরবর্তী
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- ধাপ ৩: অ্যাডমিন অ্যাকাউন্ট --}}
        <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">অ্যাডমিন অ্যাকাউন্ট 👤</h2>
                <p class="text-gray-500 text-sm mb-6">আপনার অ্যাডমিন লগইন তথ্য তৈরি করুন।</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">পুরো নাম <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.admin_name" placeholder="Admin" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">ইমেইল ঠিকানা <span class="text-red-500">*</span></label>
                        <input type="email" x-model="form.admin_email" placeholder="admin@example.com" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">পাসওয়ার্ড <span class="text-red-500">*</span></label>
                        <input type="password" x-model="form.admin_password" placeholder="কমপক্ষে ৬ অক্ষর" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">পাসওয়ার্ড নিশ্চিত করুন <span class="text-red-500">*</span></label>
                        <input type="password" x-model="form.admin_password_confirmation" placeholder="আবার পাসওয়ার্ড দিন" class="input-field">
                    </div>
                    <div x-show="adminError" class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm" x-text="adminError"></div>
                </div>
            </div>
            <div class="px-8 pb-8 flex justify-between">
                <button @click="prevStep()" class="btn-secondary">পিছনে</button>
                <button @click="validateAdminStep()" class="btn-primary">
                    পরবর্তী
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- ধাপ ৪: ইমেইল সেটিংস (ঐচ্ছিক) --}}
        <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">ইমেইল সেটিংস 📧</h2>
                <p class="text-gray-500 text-sm mb-2">Gmail SMTP দিয়ে ইমেইল পাঠান। <span class="text-blue-500 font-medium">(ঐচ্ছিক — পরে অ্যাডমিন প্যানেল থেকেও করা যাবে)</span></p>

                <div class="mb-5">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" x-model="form.skip_smtp" class="sr-only">
                            <div :class="form.skip_smtp ? 'bg-gray-300' : 'bg-blue-600'" class="w-11 h-6 rounded-full transition"></div>
                            <div :class="form.skip_smtp ? 'translate-x-1' : 'translate-x-6'" class="absolute top-1 left-0 w-4 h-4 bg-white rounded-full shadow transition transform"></div>
                        </div>
                        <span class="text-sm text-gray-600" x-text="form.skip_smtp ? 'এই ধাপ বাদ দিন (পরে সেট করব)' : 'এখনই SMTP সেট করব'"></span>
                    </label>
                </div>

                <div x-show="!form.skip_smtp" class="space-y-4">
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Gmail App Password ব্যবহার করুন:</p>
                        <p>Google Account → Security → 2-Step Verification চালু → App Passwords → Generate</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">SMTP হোস্ট</label>
                            <input type="text" x-model="form.mail_host" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">পোর্ট</label>
                            <input type="text" x-model="form.mail_port" class="input-field">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gmail ঠিকানা</label>
                        <input type="email" x-model="form.mail_username" placeholder="yourshop@gmail.com" class="input-field">
                        <script>
                            document.addEventListener('alpine:init', () => {
                                // sync mail_from_address with mail_username
                            });
                        </script>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">App Password</label>
                        <input type="password" x-model="form.mail_password" placeholder="16 সংখ্যার App Password" class="input-field">
                    </div>
                </div>
            </div>
            <div class="px-8 pb-8 flex justify-between">
                <button @click="prevStep()" class="btn-secondary">পিছনে</button>
                <button @click="nextStep()" class="btn-primary">
                    পরবর্তী
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- ধাপ ৫: ইন্সটল --}}
        <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="p-8 text-center">

                {{-- Before install --}}
                <div x-show="!installing && !installed && !installError">
                    <div class="text-6xl mb-4">🚀</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">সব প্রস্তুত!</h2>
                    <p class="text-gray-500 text-sm mb-6">নিচের বাটন চাপলে ইন্সটলেশন শুরু হবে। এই প্রক্রিয়ায় ১–২ মিনিট সময় লাগতে পারে।</p>

                    {{-- Summary --}}
                    <div class="bg-gray-50 rounded-2xl p-5 text-left mb-6 space-y-2">
                        <div class="flex justify-between text-sm"><span class="text-gray-500">দোকানের নাম</span><span class="font-semibold text-gray-800" x-text="form.app_name"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-gray-500">সাইট URL</span><span class="font-semibold text-gray-800 truncate ml-4" x-text="form.app_url"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-gray-500">ডাটাবেস</span><span class="font-semibold text-gray-800" x-text="form.db_connection.toUpperCase()"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-gray-500">অ্যাডমিন ইমেইল</span><span class="font-semibold text-gray-800" x-text="form.admin_email"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-gray-500">SMTP</span><span class="font-semibold" :class="form.skip_smtp ? 'text-yellow-600' : 'text-green-600'" x-text="form.skip_smtp ? 'পরে সেট করব' : 'কনফিগার হবে'"></span></div>
                    </div>

                    <button @click="startInstall()" class="w-full btn-primary text-base py-4">
                        ⚡ ইন্সটলেশন শুরু করুন
                    </button>
                </div>

                {{-- Installing --}}
                <div x-show="installing">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">ইন্সটল হচ্ছে...</h2>
                    <p class="text-gray-500 text-sm mb-4" x-text="installStep"></p>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000 step-line" :style="'width:' + installProgress + '%'"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2" x-text="installProgress + '% সম্পন্ন'"></p>
                </div>

                {{-- Success --}}
                <div x-show="installed">
                    <div class="text-7xl mb-5 animate-bounce">🎉</div>
                    <h2 class="text-2xl font-bold text-green-700 mb-2">ইন্সটলেশন সম্পন্ন!</h2>
                    <p class="text-gray-500 text-sm mb-6">আপনার ই-কমার্স সাইট প্রস্তুত। এখন অ্যাডমিন প্যানেল থেকে সব কিছু সেটআপ করুন।</p>
                    <a :href="form.app_url + '/admin'" class="w-full btn-primary text-base py-4 justify-center">
                        অ্যাডমিন প্যানেলে যান →
                    </a>
                </div>

                {{-- Error --}}
                <div x-show="installError">
                    <div class="text-6xl mb-4">😟</div>
                    <h2 class="text-xl font-bold text-red-700 mb-2">সমস্যা হয়েছে</h2>
                    <p class="text-red-600 text-sm mb-4" x-text="installErrorMsg"></p>
                    <button @click="installError = false; installing = false;" class="btn-secondary">
                        আবার চেষ্টা করুন
                    </button>
                </div>

            </div>
            <div class="px-8 pb-8" x-show="!installing && !installed && !installError">
                <button @click="prevStep()" class="btn-secondary">পিছনে</button>
            </div>
        </div>

    </div>

    <p class="text-center text-white/40 text-xs mt-6">Laravel Ecommerce v1.0 — Bangla UI</p>
</div>

<script>
function wizard() {
    return {
        currentStep: 0,
        steps: ['যাচাই', 'ডাটাবেস', 'সাইট', 'অ্যাডমিন', 'ইমেইল', 'ইন্সটল'],
        dbTesting: false,
        dbTestResult: null,
        dbTestError: '',
        adminError: '',
        installing: false,
        installed: false,
        installError: false,
        installErrorMsg: '',
        installStep: 'প্রস্তুতি নেওয়া হচ্ছে...',
        installProgress: 0,
        form: {
            db_connection: 'sqlite',
            db_host: '127.0.0.1',
            db_port: '3306',
            db_database: 'ecommerce',
            db_username: 'root',
            db_password: '',
            app_name: 'আমার দোকান',
            app_url: window.location.origin,
            currency: '৳',
            admin_name: '',
            admin_email: '',
            admin_password: '',
            admin_password_confirmation: '',
            skip_smtp: true,
            mail_host: 'smtp.gmail.com',
            mail_port: '587',
            mail_encryption: 'tls',
            mail_username: '',
            mail_password: '',
            mail_from_address: '',
        },

        nextStep() {
            if (this.currentStep < this.steps.length - 1) this.currentStep++;
        },
        prevStep() {
            if (this.currentStep > 0) this.currentStep--;
        },

        async testDbConnection() {
            this.dbTesting = true;
            this.dbTestResult = null;
            try {
                const res = await fetch('/setup/test-db', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                this.dbTestResult = data.success ? 'success' : 'error';
                this.dbTestError = data.message || '';
            } catch (e) {
                this.dbTestResult = 'error';
                this.dbTestError = 'সংযোগ পরীক্ষা করতে সমস্যা হয়েছে।';
            }
            this.dbTesting = false;
        },

        validateSiteStep() {
            if (!this.form.app_name.trim()) { alert('দোকানের নাম দিন।'); return; }
            if (!this.form.app_url.trim()) { alert('সাইটের URL দিন।'); return; }
            this.nextStep();
        },

        validateAdminStep() {
            this.adminError = '';
            if (!this.form.admin_name.trim()) { this.adminError = 'নাম দিন।'; return; }
            if (!this.form.admin_email.includes('@')) { this.adminError = 'সঠিক ইমেইল দিন।'; return; }
            if (this.form.admin_password.length < 6) { this.adminError = 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।'; return; }
            if (this.form.admin_password !== this.form.admin_password_confirmation) { this.adminError = 'পাসওয়ার্ড মিলছে না।'; return; }
            this.nextStep();
        },

        async startInstall() {
            this.installing = true;
            this.installProgress = 10;
            this.installStep = '.env ফাইল তৈরি হচ্ছে...';

            // Sync mail_from_address
            if (!this.form.mail_from_address) {
                this.form.mail_from_address = this.form.mail_username;
            }

            const steps = [
                { pct: 20, msg: 'ডাটাবেস সংযোগ স্থাপন হচ্ছে...' },
                { pct: 40, msg: 'টেবিল তৈরি হচ্ছে (migration)...' },
                { pct: 65, msg: 'ডিফল্ট ডেটা সেট হচ্ছে...' },
                { pct: 80, msg: 'অ্যাডমিন অ্যাকাউন্ট তৈরি হচ্ছে...' },
                { pct: 95, msg: 'চূড়ান্ত সেটআপ হচ্ছে...' },
            ];

            let stepIdx = 0;
            const stepInterval = setInterval(() => {
                if (stepIdx < steps.length) {
                    this.installProgress = steps[stepIdx].pct;
                    this.installStep = steps[stepIdx].msg;
                    stepIdx++;
                }
            }, 1500);

            try {
                const res = await fetch('/setup/install', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                clearInterval(stepInterval);

                if (data.success) {
                    this.installProgress = 100;
                    this.installStep = 'সম্পন্ন!';
                    setTimeout(() => { this.installing = false; this.installed = true; }, 800);
                } else {
                    this.installing = false;
                    this.installError = true;
                    this.installErrorMsg = data.message || 'অজানা ত্রুটি।';
                }
            } catch (e) {
                clearInterval(stepInterval);
                this.installing = false;
                this.installError = true;
                this.installErrorMsg = 'সার্ভারে সংযোগ করতে সমস্যা হয়েছে।';
            }
        }
    }
}
</script>
</body>
</html>
