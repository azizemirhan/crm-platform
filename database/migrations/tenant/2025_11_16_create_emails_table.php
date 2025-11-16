<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // sender/receiver

            // Email details
            $table->string('message_id')->unique()->nullable(); // Email server message ID
            $table->string('thread_id')->nullable(); // For grouping conversations
            $table->enum('type', ['inbox', 'sent', 'draft'])->default('inbox');
            $table->string('subject');
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();

            // Participants
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->json('to')->nullable(); // [{"email": "...", "name": "..."}]
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->json('reply_to')->nullable();

            // Status
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_spam')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();

            // Relations
            $table->nullableMorphs('related_to'); // contact_id, lead_id, account_id, opportunity_id

            // Attachments metadata
            $table->json('attachments')->nullable(); // [{"name": "...", "size": ..., "path": "..."}]
            $table->integer('attachments_count')->default(0);
            $table->bigInteger('attachments_size')->default(0); // bytes

            // Email provider info
            $table->string('provider')->nullable(); // smtp, gmail, outlook, etc.
            $table->json('headers')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id');
            $table->index('user_id');
            $table->index('thread_id');
            $table->index('type');
            $table->index('is_read');
            $table->index(['team_id', 'type', 'is_read']);
            $table->index(['related_to_type', 'related_to_id']);
            $table->fullText(['subject', 'body_text']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
