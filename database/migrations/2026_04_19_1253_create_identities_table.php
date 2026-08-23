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
        Schema::create('identities', function (Blueprint $box) {
            $box->bigIncrements('id');
            $box->foreignId('user_id')->nullable()->index();
            $box->string('identity_type'); // anonymous, student, personal, employee, candidate
            $box->string('external_id')->nullable()->index(); // NIS/NIM/EMP ID
            $box->string('tenant_id')->nullable()->index();
            $box->string('status')->default('active'); // active, graduated, inactive
            $box->unsignedBigInteger('linked_to_identity_id')->nullable()->index();
            $box->timestamp('started_at')->nullable();
            $box->timestamp('ended_at')->nullable();
            $box->timestamps();

            // Additional composite indexes or explicit naming can be added here if needed
            // User requested explicit indexes for:
            // - user_id (already indexed in foreignId)
            // - external_id (already indexed)
            // - tenant_id (already indexed)
            // - linked_to_identity_id (already indexed)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identities');
    }
};
