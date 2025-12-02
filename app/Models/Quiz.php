<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'time_limit',
        'is_active',
        'pass_threshold',
        'randomize_questions',
        'randomize_answers',
        'max_attempts',
    ];

    protected $casts = [
        'time_limit' => 'integer',
        'is_active' => 'boolean',
        'pass_threshold' => 'integer',
        'randomize_questions' => 'boolean',
        'randomize_answers' => 'boolean',
        'max_attempts' => 'integer',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('display_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function totalPoints(): int
    {
        return $this->questions->sum('points');
    }
}


