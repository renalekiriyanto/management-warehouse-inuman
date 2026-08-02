<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboundController;
use App\Http\Controllers\ProjectionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Inbounds route
    Route::prefix('inbound')->name('inbound.')->group(function () {
        Route::get('/', [InboundController::class, 'index'])->name('index');
        Route::get('/planning', [InboundController::class, 'planning'])->name('planning.index');
        Route::get('/monitoring', [InboundController::class, 'monitoring'])->name('monitoring.index');
        Route::get('/history', [InboundController::class, 'history'])->name('history.index');

        // Projection
        Route::prefix('projection')->name('projection.')->group(function () {
            Route::get('/', [ProjectionController::class, 'index'])->name('index');
            Route::get('/{projection}', [ProjectionController::class, 'show'])->name('show');
        });
    });

    // Add ons - Configuring any data like total slot in each station, etc
    Route::prefix('config')->group(function () {
        Route::prefix('slot')->group(function () {
            Route::get('/', [ConfigController::class, 'configInboundSlotIndex'])->name('config.inbound.slot.index');
            Route::post('/', [ConfigController::class, 'configInboundSlotStore'])->name('config.inbound.slot.store');
            Route::put('update/{slot}', [ConfigController::class, 'configInboundSlotUpdate'])->name('config.inbound.slot.update');
            Route::delete('update', [ConfigController::class, 'configInboundSlotDestroy'])->name('config.inbound.slot.destroy');
        });
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'pageLogin'])->name('login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'pageRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAccount'])->name('register.account');

    // Google OAuth routes
    Route::get('/google', [App\Http\Controllers\AuthController::class, 'redirectToProvider'])->name('auth.google');
    Route::get('/google/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback'])->name('auth.google.callback');
    // Complete profile
    Route::get('/complete-profile', [App\Http\Controllers\AuthController::class, 'completeProfile'])->name('auth.complete-profile');
    Route::post('/complete-profile', [App\Http\Controllers\AuthController::class, 'completeProfileSubmit'])->name('auth.complete-profile.submit');
});
