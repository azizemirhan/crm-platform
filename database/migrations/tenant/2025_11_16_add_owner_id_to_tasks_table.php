<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column doesn't exist before adding
        if (!Schema::hasColumn('tasks', 'owner_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreignId('owner_id')->nullable()->after('created_by_id')->constrained('users')->nullOnDelete();
                $table->index('owner_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tasks', 'owner_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropForeign(['owner_id']);
                $table->dropIndex(['owner_id']);
                $table->dropColumn('owner_id');
            });
        }
    }
};
