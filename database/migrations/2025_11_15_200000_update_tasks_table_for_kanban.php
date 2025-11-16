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
                $table->integer('order')->default(0);
                $table->index('order');
            });
        }

        // PostgreSQL: Add new enum values to status
        DB::statement("ALTER TYPE tasks_status_enum RENAME TO tasks_status_enum_old");
        DB::statement("CREATE TYPE tasks_status_enum AS ENUM('todo', 'not_started', 'in_progress', 'in_review', 'waiting_on_someone', 'completed', 'deferred', 'cancelled')");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status TYPE tasks_status_enum USING status::text::tasks_status_enum");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status SET DEFAULT 'todo'");
        DB::statement("DROP TYPE tasks_status_enum_old");

        // PostgreSQL: Add new enum value to priority
        DB::statement("ALTER TYPE tasks_priority_enum RENAME TO tasks_priority_enum_old");
        DB::statement("CREATE TYPE tasks_priority_enum AS ENUM('low', 'medium', 'normal', 'high', 'urgent')");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority TYPE tasks_priority_enum USING priority::text::tasks_priority_enum");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'medium'");
        DB::statement("DROP TYPE tasks_priority_enum_old");

        // Add taskable columns as aliases
        if (!Schema::hasColumn('tasks', 'taskable_type')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('taskable_type')->nullable();
                $table->unsignedBigInteger('taskable_id')->nullable();
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

        // PostgreSQL: Revert status enum
        DB::statement("ALTER TYPE tasks_status_enum RENAME TO tasks_status_enum_old");
        DB::statement("CREATE TYPE tasks_status_enum AS ENUM('not_started', 'in_progress', 'waiting_on_someone', 'completed', 'deferred', 'cancelled')");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status TYPE tasks_status_enum USING status::text::tasks_status_enum");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status SET DEFAULT 'not_started'");
        DB::statement("DROP TYPE tasks_status_enum_old");

        // PostgreSQL: Revert priority enum
        DB::statement("ALTER TYPE tasks_priority_enum RENAME TO tasks_priority_enum_old");
        DB::statement("CREATE TYPE tasks_priority_enum AS ENUM('low', 'normal', 'high', 'urgent')");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority TYPE tasks_priority_enum USING priority::text::tasks_priority_enum");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'normal'");
        DB::statement("DROP TYPE tasks_priority_enum_old");
    }
};
