<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_responses', function (Blueprint $table) {
            $table->boolean('manually_graded')->default(false)->after('points_earned');
            $table->text('feedback')->nullable()->after('manually_graded');
            $table->timestamp('reviewed_at')->nullable()->after('feedback');
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_responses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn([
                'manually_graded',
                'feedback',
                'reviewed_at',
            ]);
        });
    }
};


