<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add order column
            if (!Schema::hasColumn('tasks', 'order')) {
                $table->integer('order')->default(0);
                $table->index('order');
            }

            // Add taskable columns (polymorphic relation)
            if (!Schema::hasColumn('tasks', 'taskable_type')) {
                $table->string('taskable_type')->nullable();
                $table->unsignedBigInteger('taskable_id')->nullable();
                $table->index(['taskable_type', 'taskable_id']);
            }
        });

        // PostgreSQL için ENUM değişikliği
        // Önce default değeri kaldır
        DB::statement("ALTER TABLE tasks ALTER COLUMN status DROP DEFAULT");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority DROP DEFAULT");

        // Yeni status enum oluştur
        DB::statement("
            DO $$ 
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'task_status_new') THEN
                    CREATE TYPE task_status_new AS ENUM (
                        'todo', 
                        'not_started', 
                        'in_progress', 
                        'in_review', 
                        'waiting_on_someone', 
                        'completed', 
                        'deferred', 
                        'cancelled'
                    );
                END IF;
            END $$;
        ");

        // Status column'unu değiştir
        DB::statement("
            ALTER TABLE tasks 
            ALTER COLUMN status TYPE task_status_new 
            USING status::text::task_status_new
        ");

        // Eski enum'u sil ve yenisini yeniden adlandır
        DB::statement("DROP TYPE IF EXISTS task_status CASCADE");
        DB::statement("ALTER TYPE task_status_new RENAME TO task_status");

        // Yeni default değeri ekle
        DB::statement("ALTER TABLE tasks ALTER COLUMN status SET DEFAULT 'todo'");

        // Yeni priority enum oluştur
        DB::statement("
            DO $$ 
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'task_priority_new') THEN
                    CREATE TYPE task_priority_new AS ENUM (
                        'low', 
                        'medium', 
                        'normal', 
                        'high', 
                        'urgent'
                    );
                END IF;
            END $$;
        ");

        // Priority column'unu değiştir
        DB::statement("
            ALTER TABLE tasks 
            ALTER COLUMN priority TYPE task_priority_new 
            USING priority::text::task_priority_new
        ");

        // Eski enum'u sil ve yenisini yeniden adlandır
        DB::statement("DROP TYPE IF EXISTS task_priority CASCADE");
        DB::statement("ALTER TYPE task_priority_new RENAME TO task_priority");

        // Yeni default değeri ekle
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'medium'");
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('tasks', 'taskable_type')) {
                $table->dropColumn(['taskable_type', 'taskable_id']);
            }
        });

        // Default değerleri kaldır
        DB::statement("ALTER TABLE tasks ALTER COLUMN status DROP DEFAULT");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority DROP DEFAULT");

        // Eski status enum'a dön
        DB::statement("
            CREATE TYPE task_status_old AS ENUM (
                'not_started', 
                'in_progress', 
                'waiting_on_someone', 
                'completed', 
                'deferred', 
                'cancelled'
            )
        ");

        DB::statement("
            ALTER TABLE tasks 
            ALTER COLUMN status TYPE task_status_old 
            USING CASE 
                WHEN status = 'todo' THEN 'not_started'::task_status_old
                WHEN status = 'in_review' THEN 'in_progress'::task_status_old
                ELSE status::text::task_status_old
            END
        ");

        DB::statement("DROP TYPE task_status CASCADE");
        DB::statement("ALTER TYPE task_status_old RENAME TO task_status");
        DB::statement("ALTER TABLE tasks ALTER COLUMN status SET DEFAULT 'not_started'");

        // Eski priority enum'a dön
        DB::statement("
            CREATE TYPE task_priority_old AS ENUM (
                'low', 
                'normal', 
                'high', 
                'urgent'
            )
        ");

        DB::statement("
            ALTER TABLE tasks 
            ALTER COLUMN priority TYPE task_priority_old 
            USING CASE 
                WHEN priority = 'medium' THEN 'normal'::task_priority_old
                ELSE priority::text::task_priority_old
            END
        ");

        DB::statement("DROP TYPE task_priority CASCADE");
        DB::statement("ALTER TYPE task_priority_old RENAME TO task_priority");
        DB::statement("ALTER TABLE tasks ALTER COLUMN priority SET DEFAULT 'normal'");
    }
};