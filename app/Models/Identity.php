<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    // Tipe Identitas (Constants)
    const TYPE_PERSONAL = 'personal';
    const TYPE_ANONYMOUS = 'anonymous';
    const TYPE_STUDENT = 'student';
    const TYPE_UNIVERSITY_STUDENT = 'university_student';
    const TYPE_EMPLOYEE = 'employee';

    protected $fillable = [
        'user_id',
        'session_id',
        'name',
        'identity_type',
        'external_id',
        'tenant_id',
        'status',
        'linked_to_identity_id',
        'started_at',
        'ended_at',
        'metadata',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Hasil Asesmen.
     */
    public function assessments()
    {
        return $this->hasMany(AssessmentResult::class, 'identity_id');
    }

    /**
     * Dapatkan ID identitas terkait (personal + linked ones)
     */
    public static function getLinkedIdentityIds($personalId)
    {
        return self::where('id', $personalId)
            ->orWhere('linked_to_identity_id', $personalId)
            ->pluck('id');
    }
}
