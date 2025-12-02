<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Quiz $quiz, Question $question): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id, 404);

        $data = $request->validate([
            'answer_text' => ['required', 'string', 'max:255'],
            'is_correct' => ['boolean'],
            'explanation' => ['nullable', 'string'],
        ]);

        $question->answers()->create($data);

        return back()->with('status', 'Odpowiedź dodana.');
    }

    public function update(Request $request, Quiz $quiz, Question $question, Answer $answer): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id && $answer->question_id === $question->id, 404);

        $data = $request->validate([
            'answer_text' => ['required', 'string', 'max:255'],
            'is_correct' => ['boolean'],
            'explanation' => ['nullable', 'string'],
        ]);

        $answer->update($data);

        return back()->with('status', 'Odpowiedź zaktualizowana.');
    }

    public function destroy(Quiz $quiz, Question $question, Answer $answer): RedirectResponse
    {
        abort_unless($question->quiz_id === $quiz->id && $answer->question_id === $question->id, 404);

        $answer->delete();

        return back()->with('status', 'Odpowiedź usunięta.');
    }
}


