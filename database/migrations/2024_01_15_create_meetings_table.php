<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location')->nullable();
            $table->string('meeting_type')->default('in_person'); // in_person, online, phone
            $table->string('meeting_link')->nullable(); // For online meetings
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, rescheduled
            $table->string('priority')->default('medium'); // low, medium, high

            // Relations
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('opportunity_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');

            // Additional fields
            $table->text('notes')->nullable();
            $table->text('outcome')->nullable(); // Meeting outcome/result
            $table->json('attendees')->nullable(); // Array of user IDs
            $table->boolean('reminder_sent')->default(false);
            $table->integer('reminder_minutes_before')->default(30);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('start_time');
            $table->index('status');
            $table->index(['contact_id', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
