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
            $table->string('color')->default('#3b82f6');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->integer('usage_count')->default(0);
            
            $table->timestamps();
            
            $table->index('team_id');
            $table->unique(['team_id', 'slug']);
            $table->index('category');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            
            // morphs() yerine manuel kolonlar - böylece index kontrolümüz olur
            $table->string('taggable_type');
            $table->unsignedBigInteger('taggable_id');
            
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            
            // Önce unique index - bu hem index hem unique constraint
            $table->unique(['tag_id', 'taggable_id', 'taggable_type'], 'taggables_unique');
            
            // Polymorphic lookup için ayrı index GEREKMIYOR çünkü unique index zaten bunu kapsıyor
            // Ama performans için eklemek isterseniz:
            $table->index(['taggable_type', 'taggable_id'], 'taggables_morph_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};