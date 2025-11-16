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
            
            $table->foreignId('assigned_to_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->restrictOnDelete();
            
            // nullableMorphs() zaten index oluşturur
            $table->nullableMorphs('related_to');
            
            $table->string('title');
            $table->text('description')->nullable();
            
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['not_started', 'in_progress', 'waiting_on_someone', 'completed', 'deferred', 'cancelled'])->default('not_started');
            
            $table->timestamp('due_date')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('reminder_at')->nullable();
            $table->boolean('reminder_sent')->default(false);
            
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('completed_by_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_pattern', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('recurrence_interval')->nullable();
            $table->json('recurrence_days')->nullable();
            $table->timestamp('recurrence_ends_at')->nullable();
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            
            $table->boolean('is_private')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes - nullableMorphs() zaten related_to için index oluşturdu
            $table->index('team_id');
            $table->index('assigned_to_id');
            $table->index('created_by_id');
            // ❌ Bu satırı KALDIRDIK
            // $table->index(['related_to_type', 'related_to_id']);
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