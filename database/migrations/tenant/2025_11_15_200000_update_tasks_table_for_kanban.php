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

        // Note: status enum update is handled by 2025_11_16_fix_tasks_status_enum.php

        // PostgreSQL: Update priority to include 'medium'
        DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_priority_check");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_priority_check CHECK (priority IN ('low', 'medium', 'normal', 'high', 'urgent'))");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'medium'");

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

        // PostgreSQL: Restore original priority enum
        DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_priority_check");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_priority_check CHECK (priority IN ('low', 'normal', 'high', 'urgent'))");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'normal'");
    }
};
