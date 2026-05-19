<?php

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return '৳' . number_format($price, 2);
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('getLogo')) {
    function getLogo()
    {
        $logo = getSetting('logo');
        return $logo ? asset('uploads/' . $logo) : asset('assets/images/logo.png');
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        $favicon = getSetting('favicon');
        return $favicon ? asset('uploads/' . $favicon) : asset('assets/images/favicon.png');
    }
}

if (!function_exists('getSiteName')) {
    function getSiteName()
    {
        return getSetting('site_name', 'E-Commerce');
    }
}

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($route, $activeClass = 'bg-gray-700 text-white', $inactiveClass = 'hover:bg-gray-800 text-gray-300')
    {
        $currentRoute = request()->route();
        $currentName = $currentRoute ? $currentRoute->getName() : null;

        $matched = false;
        if (is_array($route)) {
            $matched = $currentName && in_array($currentName, $route);
        } else {
            $matched = str_ends_with($route, '*')
                ? str_starts_with((string)$currentName, rtrim($route, '*'))
                : $currentName === $route;
        }

        return $matched ? $activeClass : $inactiveClass;
    }
}

if (!function_exists('isCurrentUrl')) {
    function isCurrentUrl($url, $output = 'active')
    {
        return request()->is($url) ? $output : '';
    }
}

if (!function_exists('cartCount')) {
    function cartCount()
    {
        if (!class_exists(\App\Models\Cart::class)) {
            return 0;
        }

        if (auth()->check()) {
            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
        } else {
            $cart = \App\Models\Cart::where('session_id', session()->getId())->first();
        }
        return $cart ? $cart->getItemCount() : 0;
    }
}

if (!function_exists('wishlistCount')) {
    function wishlistCount()
    {
        if (!class_exists(\App\Models\Wishlist::class)) {
            return 0;
        }

        if (auth()->check()) {
            return \App\Models\Wishlist::where('user_id', auth()->id())->count();
        }
        return 0;
    }
}
