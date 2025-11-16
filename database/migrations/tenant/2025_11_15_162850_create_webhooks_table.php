<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            
            // Webhook Config
            $table->string('name');
            $table->string('url');
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])->default('POST');
            $table->json('headers')->nullable();
            
            // Events to trigger on
            $table->json('events'); // ['contact.created', 'lead.converted', etc.]
            
            // Filters (optional - only send if conditions met)
            $table->json('filters')->nullable();
            
            // Security
            $table->string('secret')->nullable(); // For HMAC signature
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Stats
            $table->integer('success_count')->default(0);
            $table->integer('failure_count')->default(0);
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamp('last_success_at')->nullable();
            $table->timestamp('last_failure_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('team_id');
            $table->index('is_active');
        });

        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')->constrained()->cascadeOnDelete();
            
            $table->string('event');
            $table->json('payload')->nullable();
            $table->integer('response_status')->nullable();
            $table->text('response_body')->nullable();
            $table->integer('duration')->nullable(); // milliseconds
            $table->boolean('is_success')->default(false);
            $table->text('error_message')->nullable();
            
            $table->timestamp('triggered_at');
            
            // Indexes
            $table->index('webhook_id');
            $table->index('event');
            $table->index('is_success');
            $table->index('triggered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('webhooks');
    }
};