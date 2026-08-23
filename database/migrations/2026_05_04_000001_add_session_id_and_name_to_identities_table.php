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
        Schema::table('identities', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index()->after('user_id');
            $table->string('name')->nullable()->after('session_id');
            $table->json('metadata')->nullable()->after('ended_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'name', 'metadata']);
        });
    }
};
