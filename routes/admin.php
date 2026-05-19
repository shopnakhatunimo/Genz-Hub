<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\AdminAuthController;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth:admin', 'is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Products
    Route::resource('products', ProductController::class);
    Route::get('/subcategories/by-category/{id}', [ProductController::class, 'getSubcategories'])->name('subcategories.by-category');
    Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Subcategories
    Route::resource('subcategories', SubcategoryController::class);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::match(['post','put'], '/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::match(['post','put'], '/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.update-status');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Coupons
    Route::resource('coupons', CouponController::class);
    
    // Banners
    Route::resource('banners', BannerController::class);
    
    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Settings
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::post('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
    Route::get('/settings/smtp', [SettingController::class, 'smtp'])->name('settings.smtp');
    Route::post('/settings/smtp', [SettingController::class, 'updateSmtp'])->name('settings.smtp.update');
    Route::post('/settings/smtp/test', [SettingController::class, 'testSmtp'])->name('settings.smtp.test');
    Route::get('/settings/seo', [SettingController::class, 'seo'])->name('settings.seo');
    Route::post('/settings/seo', [SettingController::class, 'updateSeo'])->name('settings.seo.update');
    Route::get('/settings/payment', [SettingController::class, 'payment'])->name('settings.payment');
    Route::post('/settings/payment', [SettingController::class, 'updatePayment'])->name('settings.payment.update');

    // Social Settings
    Route::get('/settings/social', [SettingController::class, 'social'])->name('settings.social');
    Route::post('/settings/social', [SettingController::class, 'updateSocial'])->name('settings.social.update');

    // Maintenance Mode
    Route::get('/settings/maintenance', [SettingController::class, 'maintenance'])->name('settings.maintenance');
    Route::post('/settings/maintenance/toggle', [SettingController::class, 'maintenanceToggle'])->name('settings.maintenance.toggle');
    Route::post('/settings/maintenance/message', [SettingController::class, 'maintenanceMessage'])->name('settings.maintenance.message');
});
