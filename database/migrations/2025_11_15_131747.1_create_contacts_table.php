<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('reports_to_id')->nullable()->constrained('contacts')->nullOnDelete();
            
            // Personal Info
            $table->enum('salutation', ['Mr', 'Mrs', 'Ms', 'Dr', 'Prof'])->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('full_name')->storedAs("concat(first_name, ' ', last_name)");            
            
            // Contact Info
            $table->string('email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('fax')->nullable();
            
            // Professional Info
            $table->string('title')->nullable(); // Job Title
            $table->string('department')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('linkedin_url')->nullable();
            
            // Address (Mailing)
            $table->string('mailing_street')->nullable();
            $table->string('mailing_city')->nullable();
            $table->string('mailing_state')->nullable();
            $table->string('mailing_postal_code')->nullable();
            $table->string('mailing_country')->default('TR');
            
            // Lead Information
            $table->string('lead_source')->nullable();
            $table->string('lead_source_description')->nullable();
            
            // Status & Preferences
            $table->enum('status', ['active', 'inactive', 'disqualified'])->default('active');
            $table->boolean('email_opt_out')->default(false);
            $table->boolean('do_not_call')->default(false);
            $table->boolean('sms_opt_out')->default(false);
            
            // Engagement
            $table->integer('engagement_score')->default(0); // 0-100
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('last_email_opened_at')->nullable();
            $table->timestamp('last_email_clicked_at')->nullable();
            
            // Notes
            $table->text('description')->nullable();
            
            // Custom Fields
            $table->json('custom_fields')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('account_id');
            $table->index('owner_id');
            $table->index('status');
            $table->index('email');
            $table->index('phone');
            $table->index('engagement_score');
            $table->index(['team_id', 'status']);
            $table->fullText(['first_name', 'last_name', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};