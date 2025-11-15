<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('event');
            
            // morphs() zaten index oluşturur
            $table->morphs('auditable');
            
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            $table->index('team_id');
            $table->index('user_id');
            // ❌ Bu satırı KALDIRDIK
            // $table->index(['auditable_type', 'auditable_id']);
            $table->index('event');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};