<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Auth\AuthController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/newsletter', [HomeController::class, 'newsletter'])->name('newsletter');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/categories', [ShopController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
Route::get('/subcategory/{slug}', [ShopController::class, 'subcategory'])->name('subcategory');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
    Route::get('/wishlist', [AccountController::class, 'wishlistPage'])->name('wishlist.index');
    Route::post('/wishlist/add', [AccountController::class, 'wishlistAdd'])->name('wishlist.add');
    Route::post('/wishlist/remove', [AccountController::class, 'wishlistRemove'])->name('wishlist.remove');
    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/account/addresses', [AccountController::class, 'addressStore'])->name('account.addresses.store');
    Route::post('/account/addresses/{id}', [AccountController::class, 'addressUpdate'])->name('account.addresses.default');
    Route::delete('/account/addresses/{id}', [AccountController::class, 'addressDelete'])->name('account.addresses.delete');
    
    Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
    Route::get('/order/{orderNumber}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/order/{orderNumber}/track', [OrderController::class, 'track'])->name('order.track');
    
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
