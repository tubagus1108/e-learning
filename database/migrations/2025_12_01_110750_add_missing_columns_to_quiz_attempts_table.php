<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->json('answers')->nullable()->after('submitted_at');
            $table->integer('correct_answers')->default(0)->after('score');
            $table->integer('time_taken')->nullable()->after('correct_answers');
            $table->timestamp('completed_at')->nullable()->after('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropColumn(['answers', 'correct_answers', 'time_taken', 'completed_at']);
        });
    }
};
