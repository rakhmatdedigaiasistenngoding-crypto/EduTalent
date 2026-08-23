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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            
            // Identitas User (Nullable untuk Anonymous)
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('session_id')->nullable()->index();

            // Versi dan Konteks
            $table->string('assessment_version')->default('v1');
            $table->string('domain')->nullable();

            // Input Data (Snapshot)
            $table->json('input_trait');
            $table->json('input_riasec');
            $table->json('input_environment');

            // Bobot yang digunakan
            $table->json('weights');

            // Hasil Output
            $table->json('result_top_n');
            $table->json('result_scores');
            $table->float('top_score')->nullable();

            // Metadata Tambahan (IP, Version, Browser)
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
