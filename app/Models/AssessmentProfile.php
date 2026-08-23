<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentProfile extends Model
{
    protected $fillable = [
        'result_id',
        'session_key',
        'name',
        'whatsapp',
        'email',
        'status',
        'school_level',
        'school_major',
        'school_name',
        'college_major',
        'college_name',
        'work_field',
        'company_name',
    ];

    /**
     * Label ringkas kondisi saat ini (untuk analisis perbandingan).
     */
    public function getCurrentConditionLabel(): string
    {
        return match($this->status) {
            'siswa'     => $this->school_level === 'SMK'
                            ? "Siswa SMK {$this->school_major} di {$this->school_name}"
                            : "Siswa {$this->school_level} di {$this->school_name}",
            'mahasiswa' => "Mahasiswa {$this->college_major} di {$this->college_name}",
            'pekerja'   => "Pekerja di bidang {$this->work_field} ({$this->company_name})",
            default     => 'Umum / Belum bekerja',
        };
    }

    /**
     * Ambil bidang/jurusan saat ini untuk dicocokkan dengan rekomendasi.
     */
    public function getCurrentField(): ?string
    {
        return match($this->status) {
            'siswa'     => $this->school_major ?? $this->school_level,
            'mahasiswa' => $this->college_major,
            'pekerja'   => $this->work_field,
            default     => null,
        };
    }

    public function result()
    {
        return $this->belongsTo(AssessmentResult::class, 'result_id');
    }
}
