<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central/Landing Routes
|--------------------------------------------------------------------------
|
| These routes are for the main application domain (yourcrm.com).
| They handle landing pages, tenant registration, pricing, etc.
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing.home');
})->name('home');

Route::get('/features', function () {
    return view('landing.features');
})->name('features');

Route::get('/pricing', function () {
    return view('landing.pricing');
})->name('pricing');

Route::get('/about', function () {
    return view('landing.about');
})->name('about');

Route::get('/contact', function () {
    return view('landing.contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| Tenant Registration & Management
|--------------------------------------------------------------------------
*/
Route::get('/register', [\App\Http\Controllers\Central\TenantRegistrationController::class, 'show'])
    ->name('tenant.register');

Route::post('/register', [\App\Http\Controllers\Central\TenantRegistrationController::class, 'store'])
    ->name('tenant.register.store');