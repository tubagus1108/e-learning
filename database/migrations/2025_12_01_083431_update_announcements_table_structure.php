<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['author_id']);

            // Rename column
            $table->renameColumn('author_id', 'user_id');

            // Drop old columns
            $table->dropColumn('is_published');

            // Add new column
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('content');
        });

        // Re-add foreign key with new column name
        Schema::table('announcements', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Update target_role to allow null
        DB::statement("ALTER TABLE announcements MODIFY target_role ENUM('all', 'teacher', 'student', 'parent') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['user_id']);

            // Rename back
            $table->renameColumn('user_id', 'author_id');

            // Drop new column
            $table->dropColumn('priority');

            // Add back old column
            $table->boolean('is_published')->default(true);
        });

        // Re-add foreign key with old column name
        Schema::table('announcements', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Restore target_role default
        DB::statement("ALTER TABLE announcements MODIFY target_role ENUM('all', 'teacher', 'student', 'parent') NOT NULL DEFAULT 'all'");
    }
};
