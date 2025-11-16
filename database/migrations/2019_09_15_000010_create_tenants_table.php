<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();

            // Basic tenant information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('schema_name')->unique()->nullable(); // PostgreSQL schema name

            // Owner information
            $table->string('owner_name');
            $table->string('owner_email');

            // Subscription & Plan
            $table->string('plan')->default('trial'); // trial, starter, professional, enterprise
            $table->string('status')->default('active'); // active, suspended, cancelled
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscribed_at')->nullable();

            // Limits
            $table->integer('max_users')->default(5);
            $table->integer('max_contacts')->default(1000);
            $table->integer('max_storage_mb')->default(1000);

            // Current usage tracking
            $table->integer('current_users')->default(0);
            $table->integer('current_contacts')->default(0);
            $table->integer('current_storage_mb')->default(0);

            // Features & Settings
            $table->json('features')->nullable();
            $table->json('settings')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
