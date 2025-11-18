<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    // Placeholder: future AdminQuizController will handle quiz management & reporting.
    public function index(): View
    {
        $quizzes = Quiz::withCount('questions')->orderBy('title')->get();

        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Request $request, Quiz $quiz): View
    {
        $quiz->load(['questions.answers']);

        $displayMode = $request->query('mode', config('quiz.display_mode', 'all'));
        $displayMode = in_array($displayMode, ['all', 'single'], true) ? $displayMode : 'all';

        return view('quizzes.show', [
            'quiz' => $quiz,
            'displayMode' => $displayMode,
            'questionCount' => $quiz->questions->count(),
        ]);
    }

    public function submit(Request $request, Quiz $quiz): RedirectResponse
    {
        $quiz->load(['questions.answers']);

        $rules = [
            'questions' => ['required', 'array'],
        ];

        $attributes = [];

        foreach ($quiz->questions as $question) {
            $baseKey = "questions.{$question->id}";
            if ($question->isSelectable()) {
                $rules["{$baseKey}.selected_answer_id"] = [
                    'required',
                    Rule::exists('answers', 'id')->where(fn ($query) => $query->where('question_id', $question->id)),
                ];
                $attributes["{$baseKey}.selected_answer_id"] = "question {$question->display_order}";
            } else {
                $rules["{$baseKey}.text_response"] = ['required', 'string', 'max:1000'];
                $attributes["{$baseKey}.text_response"] = "question {$question->display_order}";
            }
        }

        $validated = $request->validate($rules, [], $attributes);

        $attempt = DB::transaction(function () use ($quiz, $validated) {
            $totalPoints = $quiz->questions->sum('points');
            $userId = auth()->id();

            $attempt = QuizAttempt::create([
                'user_id' => $userId,
                'quiz_id' => $quiz->id,
                'total_points' => $totalPoints,
                'started_at' => now(),
            ]);

            $score = 0;

            foreach ($quiz->questions as $question) {
                $questionInput = $validated['questions'][$question->id] ?? [];
                $selectedAnswerId = $questionInput['selected_answer_id'] ?? null;
                $textResponse = $questionInput['text_response'] ?? null;
                $isCorrect = false;

                if ($question->isSelectable()) {
                    $answer = $question->answers->firstWhere('id', (int) $selectedAnswerId);
                    $isCorrect = (bool) ($answer?->is_correct);
                } else {
                    $expected = $question->answers->firstWhere('is_correct', true);
                    if ($expected) {
                        $isCorrect = strcasecmp(trim((string) $textResponse), trim((string) $expected->answer_text)) === 0;
                    }
                }

                $pointsEarned = $isCorrect ? $question->points : 0;
                $score += $pointsEarned;

                UserResponse::create([
                    'quiz_attempt_id' => $attempt->id,
                    'user_id' => $userId,
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'selected_answer_id' => $selectedAnswerId,
                    'text_response' => $textResponse,
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned,
                ]);
            }

            $attempt->update([
                'score' => $score,
                'completed_at' => now(),
            ]);

            return $attempt->fresh('quiz');
        });

        return redirect()
            ->route('quizzes.results', [$quiz, $attempt])
            ->with('status', 'Gratulacje! Twój wynik jest gotowy.');
    }

    public function result(Quiz $quiz, QuizAttempt $attempt): View
    {
        abort_unless($attempt->quiz_id === $quiz->id, 404);

        $attempt->load([
            'quiz.questions.answers',
            'responses.question.answers',
            'responses.selectedAnswer',
        ]);

        return view('quizzes.result', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'responses' => $attempt->responses->sortBy(fn ($response) => $response->question->display_order),
        ]);
    }
}


