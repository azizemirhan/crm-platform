<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->restrictOnDelete();
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['static', 'dynamic'])->default('static');
            $table->string('entity_type');
            $table->json('filters')->nullable();
            $table->enum('visibility', ['private', 'team', 'public'])->default('team');
            $table->integer('member_count')->default(0);
            $table->timestamp('last_calculated_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('team_id');
            $table->index('created_by_id');
            $table->index('type');
            $table->index('entity_type');
        });

        Schema::create('list_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained()->cascadeOnDelete();
            $table->foreignId('added_by_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Manuel morph kolonlar
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            
            $table->timestamps();
            
            // Unique constraint yeterli
            $table->unique(['list_id', 'entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('list_members');
        Schema::dropIfExists('lists');
    }
};