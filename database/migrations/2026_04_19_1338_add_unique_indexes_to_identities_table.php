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
            // Note: SQLite allows multiple NULLs in unique constraints.
            // These indexes prevent race conditions for specific context types.
            
            // 1. Satu User hanya boleh punya satu identitas PERSONAL.
            $table->unique(['user_id', 'identity_type'], 'uid_type_unique');
            
            // 2. Satu External ID (Session/NIM) unik per Tipe dan Tenant.
            $table->unique(['identity_type', 'external_id', 'tenant_id'], 'type_ext_tenant_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $table->dropUnique('uid_type_unique');
            $table->dropUnique('type_ext_tenant_unique');
        });
    }
};
