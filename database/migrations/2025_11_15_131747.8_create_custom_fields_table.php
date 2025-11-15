<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            
            // Field applies to which entity
            $table->string('entity_type'); // Contact, Account, Opportunity, Lead
            
            // Field Definition
            $table->string('name');
            $table->string('slug');
            $table->string('label');
            $table->text('help_text')->nullable();
            
            // Field Type
            $table->enum('type', [
                'text',
                'textarea',
                'number',
                'decimal',
                'date',
                'datetime',
                'boolean',
                'select',
                'multiselect',
                'radio',
                'checkbox',
                'email',
                'url',
                'phone',
                'currency',
                'percentage',
                'file',
                'user',
                'relation'
            ]);
            
            // Options (for select, multiselect, radio, checkbox)
            $table->json('options')->nullable();
            
            // Validation
            $table->boolean('is_required')->default(false);
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            $table->decimal('min_value', 15, 2)->nullable();
            $table->decimal('max_value', 15, 2)->nullable();
            $table->string('validation_regex')->nullable();
            
            // Default Value
            $table->text('default_value')->nullable();
            
            // Display
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('show_in_list')->default(false);
            
            // Grouping
            $table->string('group')->nullable(); // For organizing fields in sections
            
            $table->timestamps();
            
            // Indexes
            $table->index('team_id');
            $table->index('entity_type');
            $table->unique(['team_id', 'entity_type', 'slug']);
            $table->index('order');
        });

        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_field_id')->constrained()->cascadeOnDelete();
            
            // Polymorphic relationship to entity
            $table->morphs('entity');
            
            // Value (stored as JSON for flexibility)
            $table->json('value')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->unique(['custom_field_id', 'entity_type', 'entity_id'], 'custom_field_entity_unique');
            $table->index(['entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_field_values');
        Schema::dropIfExists('custom_fields');
    }
};