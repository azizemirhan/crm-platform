<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->unsignedBigInteger('converted_contact_id')->nullable();
            $table->unsignedBigInteger('converted_account_id')->nullable();
            $table->unsignedBigInteger('converted_opportunity_id')->nullable();
            
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('website')->nullable();
            
            $table->enum('source', ['web_form', 'google_ads', 'facebook_ads', 'instagram_ads', 'linkedin', 'referral', 'cold_call', 'trade_show', 'webinar', 'content_download', 'other'])->default('web_form');
            
            $table->json('source_metadata')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('referring_url')->nullable();
            $table->string('landing_page')->nullable();
            $table->ipAddress('ip_address')->nullable();
            
            $table->text('message')->nullable();
            $table->string('industry')->nullable();
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-500', '501+'])->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('currency')->default('TRY');
            $table->date('expected_close_date')->nullable();
            
            $table->enum('status', ['new', 'contacted', 'qualified', 'unqualified', 'converted', 'lost'])->default('new');
            $table->integer('score')->default(0);
            $table->enum('rating', ['hot', 'warm', 'cold'])->nullable();
            $table->string('disqualification_reason')->nullable();
            
            $table->timestamp('converted_at')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->timestamp('first_contacted_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('team_id');
            $table->index('owner_id');
            $table->index('status');
            $table->index('source');
            $table->index('score');
            $table->index(['team_id', 'status']);
            $table->fullText(['first_name', 'last_name', 'email', 'company']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};