<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboundController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Inbounds route
    Route::prefix('inbounds')->group(function () {
        Route::prefix('projection')->group(function () {
            Route::get('/', [InboundController::class, 'projection'])->name('inbounds.projection');
            Route::post('/import', [InboundController::class, 'importProjection'])->name('inbound.projection.import');
        });
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'pageLogin'])->name('login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'pageRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAccount'])->name('register.account');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    // Google OAuth routes
    Route::get('/google', [App\Http\Controllers\AuthController::class, 'redirectToProvider'])->name('auth.google');
    Route::get('/google/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback'])->name('auth.google.callback');
    // Complete profile
    Route::get('/complete-profile', [App\Http\Controllers\AuthController::class, 'completeProfile'])->name('auth.complete-profile');
    Route::post('/complete-profile', [App\Http\Controllers\AuthController::class, 'completeProfileSubmit'])->name('auth.complete-profile.submit');
});
