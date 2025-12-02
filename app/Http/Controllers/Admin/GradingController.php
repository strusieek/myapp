<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'pending');

        $query = UserResponse::query()
            ->with(['question.quiz', 'attempt'])
            ->whereHas('question', function ($q) {
                $q->where('question_type', 'short_answer');
            });

        if ($status === 'pending') {
            $query->where('manually_graded', false);
        } elseif ($status === 'reviewed') {
            $query->where('manually_graded', true);
        }

        $responses = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.grading.index', compact('responses', 'status'));
    }

    public function edit(UserResponse $response): View
    {
        $response->load(['question.quiz', 'attempt']);

        return view('admin.grading.edit', [
            'response' => $response,
            'question' => $response->question,
        ]);
    }

    public function update(Request $request, UserResponse $response): RedirectResponse
    {
        $response->load('question', 'attempt');

        $data = $request->validate([
            'points_earned' => ['required', 'integer', 'min:0', 'max:'.$response->question->points],
            'feedback' => ['nullable', 'string'],
        ]);

        $delta = $data['points_earned'] - $response->points_earned;

        $response->update([
            ...$data,
            'manually_graded' => true,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        if ($delta !== 0) {
            $response->attempt->increment('score', $delta);
        }

        return redirect()
            ->route('admin.grading.index', ['status' => 'pending'])
            ->with('status', 'Odpowiedź została oceniona.');
    }
}


