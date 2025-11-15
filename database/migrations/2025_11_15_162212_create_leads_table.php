<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            
            // Opportunity Info
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('TRY');
            
            // Sales Pipeline
            $table->enum('stage', [
                'prospecting',
                'qualification',
                'needs_analysis',
                'value_proposition',
                'proposal',
                'negotiation',
                'closed_won',
                'closed_lost'
            ])->default('prospecting');
            
            $table->integer('probability')->default(10); // 0-100 percentage
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            
            // Type & Source
            $table->enum('type', [
                'new_business',
                'existing_customer',
                'upsell',
                'cross_sell',
                'renewal'
            ])->default('new_business');
            
            $table->string('lead_source')->nullable();
            
            // Win/Loss Analysis
            $table->enum('outcome', ['won', 'lost', 'abandoned'])->nullable();
            $table->text('won_reason')->nullable();
            $table->text('loss_reason')->nullable();
            $table->foreignId('competitor_lost_to')->nullable()->constrained('accounts')->nullOnDelete();
            
            // Financial
            $table->decimal('cost_of_sale', 15, 2)->nullable();
            $table->decimal('recurring_revenue', 15, 2)->nullable();
            $table->enum('billing_frequency', ['one_time', 'monthly', 'quarterly', 'annually'])->nullable();
            
            // Forecast
            $table->boolean('is_private')->default(false);
            $table->enum('forecast_category', [
                'pipeline',
                'best_case',
                'commit',
                'omitted',
                'closed'
            ])->default('pipeline');
            
            // Description
            $table->text('description')->nullable();
            $table->text('next_steps')->nullable();
            
            // Custom Fields
            $table->json('custom_fields')->nullable();
            
            // Tracking
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('days_in_stage')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('account_id');
            $table->index('owner_id');
            $table->index('stage');
            $table->index('expected_close_date');
            $table->index('forecast_category');
            $table->index(['team_id', 'stage']);
            $table->index(['team_id', 'owner_id', 'stage']);
            $table->fullText('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};