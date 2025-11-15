<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            
            $table->string('name');
            $table->string('slug');
            $table->string('color')->default('#3b82f6'); // Hex color
            $table->text('description')->nullable();
            
            // Category (for grouping tags)
            $table->string('category')->nullable(); // e.g., 'industry', 'product', 'status'
            
            $table->integer('usage_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('team_id');
            $table->unique(['team_id', 'slug']);
            $table->index('category');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Who added the tag
            $table->timestamps();
            
            // Indexes
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->index(['taggable_type', 'taggable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};