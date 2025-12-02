<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'allow_multiple_answers',
        'points',
        'explanation',
        'time_limit',
        'display_order',
    ];

    protected $casts = [
        'points' => 'integer',
        'display_order' => 'integer',
        'question_type' => QuestionType::class,
        'allow_multiple_answers' => 'boolean',
        'time_limit' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(UserResponse::class);
    }

    public function isSelectable(): bool
    {
        return in_array($this->question_type, [QuestionType::MULTIPLE_CHOICE, QuestionType::MULTI_SELECT, QuestionType::TRUE_FALSE], true);
    }

    public function isShortAnswer(): bool
    {
        return $this->question_type === QuestionType::SHORT_ANSWER;
    }
}


