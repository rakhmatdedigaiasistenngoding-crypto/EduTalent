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
        Schema::table('assessment_results', function (Blueprint $box) {
            $box->unsignedBigInteger('identity_id')->after('session_id')->nullable()->index();
            $box->string('mode')->after('assessment_version')->nullable();
            $box->string('tenant_id')->after('mode')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $box) {
            $box->dropColumn(['identity_id', 'mode', 'tenant_id']);
        });
    }
};
