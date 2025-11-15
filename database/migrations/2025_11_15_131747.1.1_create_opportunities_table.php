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
            $table->unsignedBigInteger('lead_id')->nullable();
            
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('TRY');
            
            $table->string('stage')->default('prospecting');
            $table->integer('probability')->default(0);
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            
            $table->enum('type', ['new_business', 'existing_business', 'renewal', 'upsell', 'cross_sell'])->nullable();
            $table->string('lead_source')->nullable();
            
            $table->enum('outcome', ['won', 'lost', 'abandoned'])->nullable();
            $table->string('won_reason')->nullable();
            $table->string('loss_reason')->nullable();
            $table->unsignedBigInteger('competitor_lost_to')->nullable();
            
            $table->decimal('cost_of_sale', 15, 2)->nullable();
            $table->decimal('recurring_revenue', 15, 2)->nullable();
            $table->enum('billing_frequency', ['one_time', 'monthly', 'quarterly', 'semi_annual', 'annual'])->nullable();
            
            $table->boolean('is_private')->default(false);
            $table->enum('forecast_category', ['pipeline', 'best_case', 'commit', 'closed', 'omitted'])->default('pipeline');
            
            $table->text('description')->nullable();
            $table->text('next_steps')->nullable();
            $table->json('custom_fields')->nullable();
            
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('days_in_stage')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('team_id');
            $table->index('account_id');
            $table->index('contact_id');
            $table->index('owner_id');
            $table->index('lead_id');
            $table->index('stage');
            $table->index('outcome');
            $table->index(['team_id', 'stage']);
            $table->fullText('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};