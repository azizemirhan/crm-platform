<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // agent

            // Call details
            $table->string('call_sid')->unique()->nullable(); // Twilio Call SID
            $table->enum('direction', ['inbound', 'outbound'])->default('outbound');
            $table->enum('type', ['phone', 'voip'])->default('phone');

            // Participants
            $table->string('from_number');
            $table->string('to_number');
            $table->string('from_name')->nullable();
            $table->string('to_name')->nullable();

            // Status
            $table->enum('status', ['queued', 'ringing', 'in-progress', 'completed', 'failed', 'busy', 'no-answer', 'canceled'])->default('queued');
            $table->enum('disposition', ['answered', 'busy', 'no-answer', 'failed', 'voicemail'])->nullable();

            // Duration
            $table->timestamp('started_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration')->default(0); // seconds
            $table->integer('billable_duration')->default(0); // seconds

            // Recording
            $table->string('recording_url')->nullable();
            $table->string('recording_sid')->nullable();
            $table->integer('recording_duration')->default(0);
            $table->boolean('is_recorded')->default(false);

            // Relations
            $table->nullableMorphs('related_to'); // contact_id, lead_id, account_id, opportunity_id

            // Call notes
            $table->text('notes')->nullable();
            $table->text('summary')->nullable();
            $table->json('tags')->nullable();

            // Twilio specific
            $table->decimal('cost', 10, 4)->nullable();
            $table->string('cost_unit')->nullable(); // USD, EUR, etc.
            $table->json('twilio_data')->nullable(); // Full Twilio response

            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id');
            $table->index('user_id');
            $table->index('direction');
            $table->index('status');
            $table->index('started_at');
            $table->index(['team_id', 'direction', 'status']);
            $table->index(['related_to_type', 'related_to_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
