<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->restrictOnDelete();

            $table->string('name');
            $table->string('subject');
            $table->longText('body_html');
            $table->longText('body_text')->nullable();
            $table->string('category')->nullable(); // sales, support, marketing, etc.
            $table->json('variables')->nullable(); // Available variables: {name}, {company}, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id');
            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
