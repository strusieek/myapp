<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title');
            $table->boolean('is_active')->default(true)->after('time_limit');
            $table->unsignedInteger('pass_threshold')->nullable()->after('is_active');
            $table->boolean('randomize_questions')->default(false)->after('pass_threshold');
            $table->boolean('randomize_answers')->default(false)->after('randomize_questions');
            $table->unsignedInteger('max_attempts')->nullable()->after('randomize_answers');
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'is_active',
                'pass_threshold',
                'randomize_questions',
                'randomize_answers',
                'max_attempts',
            ]);
        });
    }
};


