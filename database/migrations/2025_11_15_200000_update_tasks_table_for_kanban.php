<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add order column
        if (!Schema::hasColumn('tasks', 'order')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->integer('order')->default(0)->after('status');
                $table->index('order');
            });
        }

        // Update status enum to include todo and in_review
        DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('todo', 'not_started', 'in_progress', 'in_review', 'waiting_on_someone', 'completed', 'deferred', 'cancelled') DEFAULT 'todo'");

        // Update priority enum to include medium
        DB::statement("ALTER TABLE tasks MODIFY COLUMN priority ENUM('low', 'medium', 'normal', 'high', 'urgent') DEFAULT 'medium'");

        // Add taskable columns as aliases
        if (!Schema::hasColumn('tasks', 'taskable_type')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('taskable_type')->nullable()->after('created_by_id');
                $table->unsignedBigInteger('taskable_id')->nullable()->after('taskable_type');
                $table->index(['taskable_type', 'taskable_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn(['taskable_type', 'taskable_id']);
        });

        DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('not_started', 'in_progress', 'waiting_on_someone', 'completed', 'deferred', 'cancelled') DEFAULT 'not_started'");
        DB::statement("ALTER TABLE tasks MODIFY COLUMN priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal'");
    }
};
