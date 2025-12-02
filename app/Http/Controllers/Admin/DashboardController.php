<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\UserResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeQuizzes = Quiz::where('is_active', true)->count();
        $totalQuizzes = Quiz::count();
        $userCount = User::count();

        $pendingOpenResponses = UserResponse::where('manually_graded', false)
            ->whereHas('question', function ($q) {
                $q->where('question_type', 'short_answer');
            })
            ->count();

        $popularQuizzes = Quiz::select('quizzes.*')
            ->withCount('attempts')
            ->orderByDesc('attempts_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'activeQuizzes',
            'totalQuizzes',
            'userCount',
            'pendingOpenResponses',
            'popularQuizzes',
        ));
    }
}


