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
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency')->default('TRY');
            $table->integer('probability')->default(50); // 0-100%
            $table->string('stage')->default('qualification'); // qualification, proposal, negotiation, closed_won, closed_lost
            $table->string('lead_source')->nullable();
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            $table->string('loss_reason')->nullable();

            // Relations
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');

            // Additional fields
            $table->text('next_steps')->nullable();
            $table->integer('sales_cycle_days')->nullable();
            $table->string('competitor')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('stage');
            $table->index('expected_close_date');
            $table->index(['owner_id', 'stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
