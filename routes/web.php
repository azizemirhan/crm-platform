<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Leads\LeadList;
/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Contacts
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/create', [ContactController::class, 'create'])->name('create');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
        Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
        
        // Contact specific actions
        Route::post('/{contact}/notes', [ContactController::class, 'addNote'])->name('notes.store');
        Route::post('/{contact}/activities', [ContactController::class, 'addActivity'])->name('activities.store');
        Route::post('/{contact}/tags', [ContactController::class, 'attachTag'])->name('tags.attach');
        Route::delete('/{contact}/tags/{tag}', [ContactController::class, 'detachTag'])->name('tags.detach');
    });

    // Accounts
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::get('/{account}', [AccountController::class, 'show'])->name('show');
        Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::delete('/{account}', [AccountController::class, 'destroy'])->name('destroy');
    });

    // Leads
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('index');
        Route::get('/create', [LeadController::class, 'create'])->name('create');
        Route::get('/{lead}', [LeadController::class, 'show'])->name('show');
        Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('edit');
        Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('destroy');
        
        // Lead actions
        Route::post('/{lead}/convert', [LeadController::class, 'convert'])->name('convert');
        Route::post('/{lead}/qualify', [LeadController::class, 'qualify'])->name('qualify');
        Route::post('/{lead}/disqualify', [LeadController::class, 'disqualify'])->name('disqualify');
    });

    // Opportunities
    Route::prefix('opportunities')->name('opportunities.')->group(function () {
        Route::get('/', [OpportunityController::class, 'index'])->name('index');
        Route::get('/create', [OpportunityController::class, 'create'])->name('create');
        Route::get('/{opportunity}', [OpportunityController::class, 'show'])->name('show');
        Route::get('/{opportunity}/edit', [OpportunityController::class, 'edit'])->name('edit');
        Route::delete('/{opportunity}', [OpportunityController::class, 'destroy'])->name('destroy');

        // Opportunity actions
        Route::patch('/{opportunity}/stage', [OpportunityController::class, 'updateStage'])->name('stage.update');
        Route::post('/{opportunity}/win', [OpportunityController::class, 'markAsWon'])->name('win');
        Route::post('/{opportunity}/lose', [OpportunityController::class, 'markAsLost'])->name('lose');
    });

    // Meetings
    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/', [MeetingController::class, 'index'])->name('index');
        Route::get('/events', [MeetingController::class, 'getEvents'])->name('events');
        Route::get('/{meeting}', [MeetingController::class, 'show'])->name('show');
        Route::put('/{meeting}', [MeetingController::class, 'update'])->name('update');
        Route::delete('/{meeting}', [MeetingController::class, 'destroy'])->name('destroy');
    });

    // Activities
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
    });

    // Tasks
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/data', [TaskController::class, 'getTasks'])->name('data');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');

        // Task actions
        Route::post('/{task}/complete', [TaskController::class, 'complete'])->name('complete');
        Route::post('/{task}/uncomplete', [TaskController::class, 'uncomplete'])->name('uncomplete');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/reorder', [TaskController::class, 'reorder'])->name('reorder');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Settings (Admin only)
    Route::middleware('role:admin')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/users', [SettingsController::class, 'users'])->name('users');
        Route::get('/roles', [SettingsController::class, 'roles'])->name('roles');
        Route::get('/custom-fields', [SettingsController::class, 'customFields'])->name('custom-fields');
        Route::get('/integrations', [SettingsController::class, 'integrations'])->name('integrations');
        Route::get('/webhooks', [SettingsController::class, 'webhooks'])->name('webhooks');
    });
});

require __DIR__.'/auth.php';