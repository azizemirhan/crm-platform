<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            // Integration details
            $table->string('provider'); // twilio, sendgrid, mailgun, stripe, etc.
            $table->string('name'); // Display name
            $table->string('type'); // sms, email, payment, telephony, etc.
            $table->boolean('is_active')->default(true);

            // Credentials (encrypted)
            $table->text('credentials'); // JSON encrypted credentials
            $table->json('config')->nullable(); // Additional configuration

            // Metadata
            $table->timestamp('last_used_at')->nullable();
            $table->integer('usage_count')->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['team_id', 'provider']);
            $table->index('team_id');
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
