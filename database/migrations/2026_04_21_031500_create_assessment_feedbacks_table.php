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
        Schema::create('assessment_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating')->comment('1: Tidak sesuai, 5: Sangat sesuai');
            $table->text('note')->nullable();
            $table->string('source')->nullable()->default('web');
            $table->timestamps();

            // Constraint: Satu result hanya boleh memiliki satu feedback
            $table->unique('assessment_result_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_feedbacks');
    }
};
