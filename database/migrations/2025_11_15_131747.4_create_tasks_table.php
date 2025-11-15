<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            
            // Assignment
            $table->foreignId('assigned_to_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->restrictOnDelete();
            
            // Polymorphic relationship (optional)
            $table->nullableMorphs('related_to');
            
            // Task Info
            $table->string('title');
            $table->text('description')->nullable();
            
            // Priority & Status
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', [
                'not_started',
                'in_progress',
                'waiting_on_someone',
                'completed',
                'deferred',
                'cancelled'
            ])->default('not_started');
            
            // Timing
            $table->timestamp('due_date')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('reminder_at')->nullable();
            $table->boolean('reminder_sent')->default(false);
            
            // Completion
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('completed_by_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Recurrence
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_pattern', [
                'daily',
                'weekly',
                'monthly',
                'yearly'
            ])->nullable();
            $table->integer('recurrence_interval')->nullable(); // Every X days/weeks/months
            $table->json('recurrence_days')->nullable(); // For weekly: [1,3,5] = Mon, Wed, Fri
            $table->timestamp('recurrence_ends_at')->nullable();
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            
            // Visibility
            $table->boolean('is_private')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('assigned_to_id');
            $table->index('created_by_id');
            $table->index(['related_to_type', 'related_to_id']);
            $table->index('status');
            $table->index('priority');
            $table->index('due_date');
            $table->index('is_completed');
            $table->index(['team_id', 'assigned_to_id', 'status']);
            $table->index(['team_id', 'due_date']);
            $table->fullText('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};