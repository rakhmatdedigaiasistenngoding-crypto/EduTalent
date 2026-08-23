<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'trait',
        'riasec',
        'environment',
        'work_values',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'trait' => 'array',
        'riasec' => 'array',
        'environment' => 'array',
        'work_values' => 'array',
        'metadata' => 'array',
    ];
}
