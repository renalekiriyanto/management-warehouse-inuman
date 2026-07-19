<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'pageLogin'])->name('login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'pageRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAccount'])->name('register.account');

    // Google OAuth routes
    Route::get('/google', [App\Http\Controllers\AuthController::class, 'redirectToProvider'])->name('auth.google');
    Route::get('/google/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback'])->name('auth.google.callback');
});
