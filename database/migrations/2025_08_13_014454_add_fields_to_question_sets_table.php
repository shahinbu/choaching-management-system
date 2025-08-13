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
        Schema::table('question_sets', function (Blueprint $table) {
            $table->integer('difficulty_level')->nullable()->after('time_limit');
            $table->boolean('randomize_questions')->default(false)->after('difficulty_level');
            $table->boolean('show_results')->default(true)->after('randomize_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question_sets', function (Blueprint $table) {
            $table->dropColumn(['difficulty_level', 'randomize_questions', 'show_results']);
        });
    }
};