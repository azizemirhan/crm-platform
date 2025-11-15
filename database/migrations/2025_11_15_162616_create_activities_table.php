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
            
            // Polymorphic relationship (contact, account, opportunity, lead)
            $table->morphs('subject');
            
            // User who performed the activity
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Activity Type
            $table->enum('type', [
                'call',
                'email',
                'meeting',
                'note',
                'sms',
                'whatsapp',
                'task_completed',
                'opportunity_stage_change',
                'lead_status_change',
                'file_upload',
                'quote_sent',
                'contract_signed',
                'system'
            ]);
            
            // Direction (for communication activities)
            $table->enum('direction', ['inbound', 'outbound', 'internal'])->nullable();
            
            // Status
            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
                'no_show'
            ])->default('completed');
            
            // Title & Description
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            // Timing
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration')->nullable(); // minutes
            
            // Communication specific
            $table->string('from')->nullable(); // Email/Phone
            $table->string('to')->nullable(); // Email/Phone
            $table->text('cc')->nullable(); // Email CC (JSON array)
            $table->text('bcc')->nullable(); // Email BCC (JSON array)
            
            // Call specific
            $table->string('call_sid')->nullable(); // Twilio Call SID
            $table->enum('call_status', [
                'initiated',
                'ringing',
                'in_progress',
                'completed',
                'busy',
                'no_answer',
                'failed',
                'cancelled'
            ])->nullable();
            $table->string('recording_url')->nullable();
            $table->integer('call_duration')->nullable(); // seconds
            
            // Email specific
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
            
            // SMS/WhatsApp specific
            $table->string('message_sid')->nullable(); // Twilio Message SID
            $table->enum('message_status', [
                'queued',
                'sent',
                'delivered',
                'failed',
                'undelivered'
            ])->nullable();
            
            // Meeting specific
            $table->string('location')->nullable();
            $table->json('attendees')->nullable(); // User IDs or external emails
            $table->string('meeting_url')->nullable(); // Google Meet, Zoom, etc.
            $table->boolean('all_day')->default(false);
            
            // Metadata
            $table->json('metadata')->nullable(); // Flexible field for additional data
            
            // Visibility
            $table->boolean('is_private')->default(false);
            $table->boolean('is_pinned')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('user_id');
            $table->index(['subject_type', 'subject_id']);
            $table->index('type');
            $table->index('status');
            $table->index('scheduled_at');
            $table->index('completed_at');
            $table->index(['team_id', 'type']);
            $table->index(['team_id', 'user_id', 'created_at']);
            $table->index('call_sid');
            $table->index('email_message_id');
            $table->index('message_sid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};