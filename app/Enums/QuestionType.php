<?php

namespace App\Enums;

enum QuestionType: string
{
    case MULTIPLE_CHOICE = 'multiple_choice';
    case MULTI_SELECT = 'multi_select';
    case TRUE_FALSE = 'true_false';
    case SHORT_ANSWER = 'short_answer';

    public function label(): string
    {
        return match ($this) {
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::MULTI_SELECT => 'Multi Select',
            self::TRUE_FALSE => 'True / False',
            self::SHORT_ANSWER => 'Short Answer',
        };
    }
}


