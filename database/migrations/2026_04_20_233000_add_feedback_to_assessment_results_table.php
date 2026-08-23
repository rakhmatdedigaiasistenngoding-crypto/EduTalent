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
        Schema::table('assessment_results', function (Blueprint $blueprint) {
            $blueprint->unsignedTinyInteger('feedback_accuracy')->nullable()->after('metadata');
            $blueprint->text('feedback_comment')->nullable()->after('feedback_accuracy');
            $blueprint->timestamp('feedback_at')->nullable()->after('feedback_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['feedback_accuracy', 'feedback_comment', 'feedback_at']);
        });
    }
};
