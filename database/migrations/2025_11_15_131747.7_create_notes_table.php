<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Polymorphic relationship
            $table->morphs('notable');
            
            // Note Content
            $table->string('title')->nullable();
            $table->text('content');
            
            // Visibility
            $table->boolean('is_private')->default(false);
            $table->boolean('is_pinned')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('user_id');
            $table->index(['notable_type', 'notable_id']);
            $table->index('is_pinned');
            $table->fullText('content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};