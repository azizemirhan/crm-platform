<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update tasks status enum to include in_review
        DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_status_check");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_status_check CHECK (status IN ('todo', 'not_started', 'in_progress', 'in_review', 'waiting_on_someone', 'completed', 'deferred', 'cancelled'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_status_check");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_status_check CHECK (status IN ('todo', 'not_started', 'in_progress', 'waiting_on_someone', 'completed', 'deferred', 'cancelled'))");
    }
};
