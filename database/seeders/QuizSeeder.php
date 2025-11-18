<?php

namespace Database\Seeders;

use App\Enums\QuestionType;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'title' => 'PHP Fundamentals',
                'description' => 'Sprawdź podstawową znajomość PHP, typów i standardowych funkcji.',
                'time_limit' => 15,
                'questions' => [
                    [
                        'question_text' => 'Co zwraca funkcja count([1, 2, 3])?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => '1', 'is_correct' => false],
                            ['answer_text' => '2', 'is_correct' => false],
                            ['answer_text' => '3', 'is_correct' => true],
                            ['answer_text' => '4', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Instrukcja require_once przerywa działanie skryptu, gdy plik nie istnieje.',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 1,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => true],
                            ['answer_text' => 'Fałsz', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Jakie słowo kluczowe użyjesz, aby utworzyć klasę anonimową w PHP 8?',
                        'question_type' => QuestionType::SHORT_ANSWER,
                        'points' => 3,
                        'answers' => [
                            ['answer_text' => 'new class', 'is_correct' => true],
                        ],
                    ],
                    [
                        'question_text' => 'Która funkcja przekształci tablicę w string z separatorem?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'explode', 'is_correct' => false],
                            ['answer_text' => 'implode', 'is_correct' => true],
                            ['answer_text' => 'join_array', 'is_correct' => false],
                            ['answer_text' => 'concat', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Domyślna widoczność właściwości w klasie to public.',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => false],
                            ['answer_text' => 'Fałsz', 'is_correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'General Programming Concepts',
                'description' => 'Algorytmy, struktury danych i dobre praktyki kodowania.',
                'time_limit' => 20,
                'questions' => [
                    [
                        'question_text' => 'Która struktura danych działa w modelu FIFO?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Stos', 'is_correct' => false],
                            ['answer_text' => 'Kolejka', 'is_correct' => true],
                            ['answer_text' => 'Graf', 'is_correct' => false],
                            ['answer_text' => 'Drzewo', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Złożoność czasowa wyszukiwania binarnego to O(log n).',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => true],
                            ['answer_text' => 'Fałsz', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Jak nazywa się wzorzec projektowy, który zapewnia tylko jedną instancję klasy?',
                        'question_type' => QuestionType::SHORT_ANSWER,
                        'points' => 3,
                        'answers' => [
                            ['answer_text' => 'singleton', 'is_correct' => true],
                        ],
                    ],
                    [
                        'question_text' => 'Który typ sortowania jest stabilny?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Quick sort', 'is_correct' => false],
                            ['answer_text' => 'Merge sort', 'is_correct' => true],
                            ['answer_text' => 'Heap sort', 'is_correct' => false],
                            ['answer_text' => 'Selection sort', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Programowanie defensywne oznacza pisanie testów jednostkowych.',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 1,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => false],
                            ['answer_text' => 'Fałsz', 'is_correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Laravel & Web Essentials',
                'description' => 'Pytania o Laravel, HTTP i podstawowe narzędzia webowe.',
                'time_limit' => null,
                'questions' => [
                    [
                        'question_text' => 'Które polecenie tworzy nowy model w Laravelu?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'php artisan model:make', 'is_correct' => false],
                            ['answer_text' => 'php artisan make:model', 'is_correct' => true],
                            ['answer_text' => 'php artisan create:model', 'is_correct' => false],
                            ['answer_text' => 'php artisan new:model', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Metoda HTTP PUT jest idempotentna.',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => true],
                            ['answer_text' => 'Fałsz', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Jak nazywa się funkcja pomocnicza do tworzenia adresów podpisanych w Laravelu?',
                        'question_type' => QuestionType::SHORT_ANSWER,
                        'points' => 3,
                        'answers' => [
                            ['answer_text' => 'URL::signedRoute', 'is_correct' => true],
                        ],
                    ],
                    [
                        'question_text' => 'Który komponent odpowiada za warstwę widoków w MVC w Laravelu?',
                        'question_type' => QuestionType::MULTIPLE_CHOICE,
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Blade', 'is_correct' => true],
                            ['answer_text' => 'Eloquent', 'is_correct' => false],
                            ['answer_text' => 'Sanctum', 'is_correct' => false],
                            ['answer_text' => 'Broadcasting', 'is_correct' => false],
                        ],
                    ],
                    [
                        'question_text' => 'Middleware może zostać przypisany do tras.',
                        'question_type' => QuestionType::TRUE_FALSE,
                        'points' => 1,
                        'answers' => [
                            ['answer_text' => 'Prawda', 'is_correct' => true],
                            ['answer_text' => 'Fałsz', 'is_correct' => false],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($quizzes as $quizData) {
            $questions = $quizData['questions'];
            unset($quizData['questions']);

            $quiz = Quiz::create($quizData);

            foreach ($questions as $index => $questionData) {
                $answers = $questionData['answers'];
                unset($questionData['answers']);

                /** @var Question $question */
                $question = $quiz->questions()->create([
                    ...$questionData,
                    'question_type' => $questionData['question_type']->value,
                    'display_order' => $index + 1,
                ]);

                foreach ($answers as $answerData) {
                    $question->answers()->create($answerData);
                }
            }
        }
    }
}


