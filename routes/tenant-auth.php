<?php

use App\Http\Controllers\Tenant\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle authentication for tenant users.
| Each tenant has separate authentication.
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('tenant.login');
    Route::post('/login', [AuthController::class, 'login'])->name('tenant.login.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('tenant.password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('tenant.password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('tenant.password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('tenant.password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('tenant.logout');
});
