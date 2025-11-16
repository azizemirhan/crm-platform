<?php

use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\SuperAdmin\ImpersonateController;
use App\Http\Controllers\SuperAdmin\AnalyticsController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
|
| Routes for platform administrators to manage all tenants,
| view analytics, and configure system settings.
|
*/

/*
|--------------------------------------------------------------------------
| Super Admin Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('super-admin')->name('super-admin.')->group(function () {

    // Guest Routes (Login)
    Route::middleware('guest:super-admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    // Authenticated Routes
    Route::middleware(['auth:super-admin'])->group(function () {

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Tenant Management
        |--------------------------------------------------------------------------
        */
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/', [TenantController::class, 'index'])->name('index');
            Route::get('/create', [TenantController::class, 'create'])->name('create');
            Route::post('/', [TenantController::class, 'store'])->name('store');
            Route::get('/{tenant}', [TenantController::class, 'show'])->name('show');
            Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('edit');
            Route::put('/{tenant}', [TenantController::class, 'update'])->name('update');
            Route::delete('/{tenant}', [TenantController::class, 'destroy'])->name('destroy');

            // Tenant Actions
            Route::post('/{tenant}/suspend', [TenantController::class, 'suspend'])->name('suspend');
            Route::post('/{tenant}/activate', [TenantController::class, 'activate'])->name('activate');
            Route::post('/{tenant}/cancel-subscription', [TenantController::class, 'cancelSubscription'])->name('cancel-subscription');

            // Tenant Data & Stats
            Route::get('/{tenant}/usage', [TenantController::class, 'usage'])->name('usage');
            Route::get('/{tenant}/activity', [TenantController::class, 'activity'])->name('activity');
        });

        /*
        |--------------------------------------------------------------------------
        | Impersonation
        |--------------------------------------------------------------------------
        */
        Route::post('/tenants/{tenant}/impersonate', [ImpersonateController::class, 'start'])
            ->name('impersonate');
        Route::post('/impersonate/leave', [ImpersonateController::class, 'leave'])
            ->name('impersonate.leave');

        /*
        |--------------------------------------------------------------------------
        | Analytics & Reports
        |--------------------------------------------------------------------------
        */
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('revenue');
            Route::get('/growth', [AnalyticsController::class, 'growth'])->name('growth');
            Route::get('/churn', [AnalyticsController::class, 'churn'])->name('churn');
        });

        /*
        |--------------------------------------------------------------------------
        | System Settings
        |--------------------------------------------------------------------------
        */
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::put('/', [SettingsController::class, 'update'])->name('update');

            // Super Admins Management
            Route::get('/admins', [SettingsController::class, 'admins'])->name('admins');
            Route::post('/admins', [SettingsController::class, 'storeAdmin'])->name('admins.store');
            Route::delete('/admins/{admin}', [SettingsController::class, 'destroyAdmin'])->name('admins.destroy');

            // Plans & Pricing
            Route::get('/plans', [SettingsController::class, 'plans'])->name('plans');
            Route::put('/plans', [SettingsController::class, 'updatePlans'])->name('plans.update');

            // Email Templates
            Route::get('/emails', [SettingsController::class, 'emails'])->name('emails');
            Route::put('/emails', [SettingsController::class, 'updateEmails'])->name('emails.update');
        });
    });
});
