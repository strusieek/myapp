<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_attempt_id',
        'user_id',
        'quiz_id',
        'question_id',
        'selected_answer_id',
        'text_response',
        'is_correct',
        'points_earned',
        'manually_graded',
        'feedback',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
        'manually_graded' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedAnswer(): BelongsTo
    {
        return $this->belongsTo(Answer::class, 'selected_answer_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}


