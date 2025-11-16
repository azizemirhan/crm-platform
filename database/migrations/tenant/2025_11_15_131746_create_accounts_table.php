<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('parent_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('tax_office')->nullable();
            
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            
            $table->string('billing_address_line1')->nullable();
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->default('TR');
            
            $table->string('shipping_address_line1')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->default('TR');
            
            $table->string('industry')->nullable();
            $table->enum('type', ['prospect', 'customer', 'partner', 'vendor', 'other'])->default('prospect');
            $table->enum('size', ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'])->nullable();
            $table->integer('employee_count')->nullable();
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->string('currency')->default('TRY');
            
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_handle')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_handle')->nullable();
            
            $table->string('source')->nullable();
            $table->string('source_details')->nullable();
            $table->text('description')->nullable();
            
            $table->json('custom_fields')->nullable();
            
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('team_id');
            $table->index('owner_id');
            $table->index('type');
            $table->index('industry');
            $table->index(['team_id', 'name']);
            $table->fullText(['name', 'legal_name', 'website']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};