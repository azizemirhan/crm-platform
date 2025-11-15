<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->morphs('subject');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->enum('type', ['call', 'email', 'meeting', 'note', 'sms', 'whatsapp', 'task_completed', 'opportunity_stage_change', 'lead_status_change', 'file_upload', 'quote_sent', 'contract_signed', 'system']);
            $table->enum('direction', ['inbound', 'outbound', 'internal'])->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('completed');
            
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration')->nullable();
            
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            
            $table->string('call_sid')->nullable();
            $table->enum('call_status', ['initiated', 'ringing', 'in_progress', 'completed', 'busy', 'no_answer', 'failed', 'cancelled'])->nullable();
            $table->string('recording_url')->nullable();
            $table->integer('call_duration')->nullable();
            
            $table->string('email_message_id')->nullable();
            $table->boolean('email_opened')->default(false);
            $table->integer('email_open_count')->default(0);
            $table->timestamp('email_first_opened_at')->nullable();
            $table->timestamp('email_last_opened_at')->nullable();
            $table->boolean('email_clicked')->default(false);
            $table->integer('email_click_count')->default(0);
            $table->timestamp('email_first_clicked_at')->nullable();
            $table->boolean('email_bounced')->default(false);
            $table->string('email_bounce_reason')->nullable();
            
            $table->string('message_sid')->nullable();
            $table->enum('message_status', ['queued', 'sent', 'delivered', 'failed', 'undelivered'])->nullable();
            
            $table->string('location')->nullable();
            $table->json('attendees')->nullable();
            $table->string('meeting_url')->nullable();
            $table->boolean('all_day')->default(false);
            
            $table->json('metadata')->nullable();
            $table->boolean('is_private')->default(false);
            $table->boolean('is_pinned')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('team_id');
            $table->index('user_id');
            $table->index(['subject_type', 'subject_id']);
            $table->index('type');
            $table->index('status');
            $table->index(['team_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};