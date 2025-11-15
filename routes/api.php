<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\OpportunityController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    
    // Contacts API
    Route::apiResource('contacts', ContactController::class);
    Route::post('contacts/{contact}/activities', [ContactController::class, 'storeActivity']);
    Route::post('contacts/{contact}/notes', [ContactController::class, 'storeNote']);
    
    // Accounts API
    Route::apiResource('accounts', AccountController::class);
    
    // Leads API
    Route::apiResource('leads', LeadController::class);
    Route::post('leads/{lead}/convert', [LeadController::class, 'convert']);
    Route::post('leads/{lead}/score', [LeadController::class, 'updateScore']);
    
    // Opportunities API
    Route::apiResource('opportunities', OpportunityController::class);
    Route::patch('opportunities/{opportunity}/stage', [OpportunityController::class, 'updateStage']);
    
    // Activities API
    Route::apiResource('activities', ActivityController::class)->only(['index', 'show', 'destroy']);
    
    // Tasks API
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete']);
    
    // Dashboard Stats
    Route::get('dashboard/stats', function () {
        return response()->json([
            'contacts_count' => \App\Models\Contact::count(),
            'leads_count' => \App\Models\Lead::whereIn('status', ['new', 'contacted'])->count(),
            'opportunities_count' => \App\Models\Opportunity::open()->count(),
            'tasks_due_today' => \App\Models\Task::dueToday()->count(),
        ]);
    });
});

// Public webhooks (for external integrations)
Route::post('webhooks/form-submit', [App\Http\Controllers\WebhookController::class, 'formSubmit'])->name('webhooks.form-submit');
Route::post('webhooks/twilio/call', [App\Http\Controllers\TwilioWebhookController::class, 'incomingCall'])->name('webhooks.twilio.call');
Route::post('webhooks/twilio/sms', [App\Http\Controllers\TwilioWebhookController::class, 'incomingSms'])->name('webhooks.twilio.sms');