<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setup\SetupController;

/*
|--------------------------------------------------------------------------
| Setup / Installation Routes
|--------------------------------------------------------------------------
|
| এই routes শুধুমাত্র প্রথম ইন্সটলেশনের জন্য।
| ইন্সটলেশন সম্পন্ন হলে storage/installed ফাইল তৈরি হয়
| এবং এই routes আর কাজ করে না।
|
*/

Route::get('/setup', [SetupController::class, 'index'])->name('setup');
Route::post('/setup/test-db', [SetupController::class, 'testDb'])->name('setup.test-db');
Route::post('/setup/install', [SetupController::class, 'install'])->name('setup.install');
