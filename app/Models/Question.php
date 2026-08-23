<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'dimension',
        'key',
        'weight',
        'module',
        'sub_dimension',
        'is_reflective',
        'display_order',
        'discrimination_a',
        'difficulty_b',
    ];

    protected $casts = [
        'is_reflective'    => 'boolean',
        'discrimination_a' => 'float',
        'difficulty_b'     => 'float',
    ];
}
