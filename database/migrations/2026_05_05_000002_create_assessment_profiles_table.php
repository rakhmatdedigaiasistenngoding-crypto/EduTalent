<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_profiles', function (Blueprint $table) {
            $table->id();

            // Link ke sesi / hasil asesmen (nullable, diisi setelah submit asesmen)
            $table->unsignedBigInteger('result_id')->nullable()->index();
            $table->string('session_key')->index(); // session ID sebelum result ada

            // Data Pribadi
            $table->string('name');
            $table->string('whatsapp', 20)->nullable();
            $table->string('email')->nullable();

            // Status
            $table->enum('status', ['umum', 'siswa', 'mahasiswa', 'pekerja'])->default('umum');

            // Siswa/Pelajar
            $table->enum('school_level', ['SMP', 'SMA', 'SMK'])->nullable();
            $table->string('school_major')->nullable();  // Jurusan (jika SMK)
            $table->string('school_name')->nullable();   // Nama sekolah

            // Mahasiswa
            $table->string('college_major')->nullable(); // Jurusan/Prodi
            $table->string('college_name')->nullable();  // Nama kampus

            // Pekerja/Karyawan
            $table->string('work_field')->nullable();    // Bidang profesi
            $table->string('company_name')->nullable();  // Nama perusahaan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_profiles');
    }
};
