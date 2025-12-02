<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz): RedirectResponse
    {
        $data = $request->validate([
            'question_text' => ['required', 'string'],
            'question_type' => ['required', 'string', 'in:'.collect(QuestionType::cases())->pluck('value')->implode(',')],
            'allow_multiple_answers' => ['boolean'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
            'explanation' => ['nullable', 'string'],
            'time_limit' => ['nullable', 'integer', 'min:1', 'max:3600'],
        ]);

        $displayOrder = (int) $quiz->questions()->max('display_order') + 1;

        $quiz->questions()->create([
            ...$data,
            'display_order' => $displayOrder,
        ]);

        return back()->with('status', 'Pytanie dodane.');
    }

    public function update(Request $request, Quiz $quiz, Question $question): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $data = $request->validate([
            'question_text' => ['required', 'string'],
            'question_type' => ['required', 'string', 'in:'.collect(QuestionType::cases())->pluck('value')->implode(',')],
            'allow_multiple_answers' => ['boolean'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
            'explanation' => ['nullable', 'string'],
            'time_limit' => ['nullable', 'integer', 'min:1', 'max:3600'],
        ]);

        $question->update($data);

        return back()->with('status', 'Pytanie zaktualizowane.');
    }

    public function destroy(Quiz $quiz, Question $question): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $question->delete();

        return back()->with('status', 'Pytanie usunięte.');
    }

    public function moveUp(Quiz $quiz, Question $question): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $previous = $quiz->questions()
            ->where('display_order', '<', $question->display_order)
            ->orderByDesc('display_order')
            ->first();

        if ($previous) {
            [$question->display_order, $previous->display_order] = [$previous->display_order, $question->display_order];
            $question->save();
            $previous->save();
        }

        return back();
    }

    public function moveDown(Quiz $quiz, Question $question): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $next = $quiz->questions()
            ->where('display_order', '>', $question->display_order)
            ->orderBy('display_order')
            ->first();

        if ($next) {
            [$question->display_order, $next->display_order] = [$next->display_order, $question->display_order];
            $question->save();
            $next->save();
        }

        return back();
    }
}


