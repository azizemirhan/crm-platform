<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by_id')->constrained('users')->restrictOnDelete();
            
            // Polymorphic relationship
            $table->nullableMorphs('mediable');
            
            // File Info
            $table->string('name');
            $table->string('original_name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('size'); // bytes
            
            // Storage
            $table->string('disk')->default('local'); // local, s3, gcs
            $table->string('path');
            $table->string('url')->nullable();
            
            // Image specific
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            
            // Document specific
            $table->integer('page_count')->nullable();
            
            // Metadata
            $table->json('metadata')->nullable();
            $table->text('description')->nullable();
            
            // Versioning
            $table->integer('version')->default(1);
            $table->foreignId('parent_media_id')->nullable()->constrained('media')->nullOnDelete();
            
            // Access Control
            $table->boolean('is_public')->default(false);
            $table->string('access_token')->nullable()->unique();
            $table->timestamp('access_token_expires_at')->nullable();
            
            // Virus Scan
            $table->enum('scan_status', ['pending', 'clean', 'infected', 'error'])->nullable();
            $table->timestamp('scanned_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('team_id');
            $table->index('uploaded_by_id');
            $table->index(['mediable_type', 'mediable_id']);
            $table->index('mime_type');
            $table->index('created_at');
            $table->fullText(['name', 'original_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};