<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(Request $request): View
    {
        $query = Quiz::query()
            ->withCount('questions')
            ->orderBy($request->get('sort', 'created_at'), $request->get('direction', 'desc'));

        if ($search = $request->get('search')) {
            $query->where(fn ($q) => $q
                ->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%"));
        }

        if (! is_null($request->get('active'))) {
            $query->where('is_active', (bool) $request->boolean('active'));
        }

        $quizzes = $query->paginate(15)->withQueryString();

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'time_limit' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'is_active' => ['boolean'],
            'pass_threshold' => ['nullable', 'integer', 'min:0'],
            'randomize_questions' => ['boolean'],
            'randomize_answers' => ['boolean'],
            'max_attempts' => ['nullable', 'integer', 'min:1'],
        ]);

        $quiz = Quiz::create($data);

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('status', 'Quiz utworzony. Możesz teraz dodać pytania.');
    }

    public function edit(Quiz $quiz): View
    {
        $quiz->load(['questions.answers']);

        return view('admin.quizzes.edit', [
            'quiz' => $quiz,
            'questionTypes' => QuestionType::cases(),
        ]);
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'time_limit' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'is_active' => ['boolean'],
            'pass_threshold' => ['nullable', 'integer', 'min:0'],
            'randomize_questions' => ['boolean'],
            'randomize_answers' => ['boolean'],
            'max_attempts' => ['nullable', 'integer', 'min:1'],
        ]);

        $quiz->update($data);

        return back()->with('status', 'Quiz zaktualizowany.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->attempts()->exists()) {
            return back()->withErrors([
                'quiz' => 'Nie można usunąć quizu, który ma już podejścia użytkowników.',
            ]);
        }

        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', 'Quiz został usunięty.');
    }

    public function toggleActive(Quiz $quiz): RedirectResponse
    {
        $quiz->update([
            'is_active' => ! $quiz->is_active,
        ]);

        return back()->with('status', 'Status quizu został zaktualizowany.');
    }

    public function duplicate(Quiz $quiz): RedirectResponse
    {
        $copy = $quiz->replicate([
            'title',
            'category',
            'description',
            'time_limit',
            'is_active',
            'pass_threshold',
            'randomize_questions',
            'randomize_answers',
            'max_attempts',
        ]);

        $copy->title = $quiz->title.' (kopiuj)';
        $copy->push();

        $quiz->loadMissing('questions.answers');

        foreach ($quiz->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->quiz_id = $copy->id;
            $newQuestion->push();

            foreach ($question->answers as $answer) {
                $newAnswer = $answer->replicate();
                $newAnswer->question_id = $newQuestion->id;
                $newAnswer->push();
            }
        }

        return redirect()
            ->route('admin.quizzes.edit', $copy)
            ->with('status', 'Quiz został zduplikowany.');
    }
}


