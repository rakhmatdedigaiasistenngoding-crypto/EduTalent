<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'identity_id',
        'assessment_version',
        'mode',
        'tenant_id',
        'domain',
        'input_trait',
        'input_riasec',
        'input_environment',
        'weights',
        'result_top_n',
        'result_scores',
        'top_score',
        'metadata',
        'narasi_json',
        'feedback_accuracy',
        'feedback_comment',
        'feedback_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'input_trait' => 'array',
        'input_riasec' => 'array',
        'input_environment' => 'array',
        'weights' => 'array',
        'result_top_n' => 'array',
        'result_scores' => 'array',
        'metadata' => 'array',
        'narasi_json' => 'array',
    ];
    /**
     * Relasi ke Identity.
     */
    public function identity()
    {
        return $this->belongsTo(Identity::class, 'identity_id');
    }

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke AssessmentFeedback.
     */
    public function feedback()
    {
        return $this->hasOne(AssessmentFeedback::class);
    }
}
