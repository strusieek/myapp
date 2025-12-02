<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\AnswerController as AdminAnswerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GradingController as AdminGradingController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quizzes/{quiz}', [QuizController::class, 'submit'])->name('quizzes.submit');
Route::get('/quizzes/{quiz}/results/{attempt}', [QuizController::class, 'result'])->name('quizzes.results');

Route::prefix('admin')->as('admin.')->group(function () {
    // Prosty panel admina bez autoryzacji – w przyszłości można dodać middleware 'auth' i 'can:admin'.
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('quizzes', AdminQuizController::class)->except(['show']);
    Route::post('quizzes/{quiz}/toggle-active', [AdminQuizController::class, 'toggleActive'])->name('quizzes.toggle-active');
    Route::post('quizzes/{quiz}/duplicate', [AdminQuizController::class, 'duplicate'])->name('quizzes.duplicate');

    Route::post('quizzes/{quiz}/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::put('quizzes/{quiz}/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('quizzes/{quiz}/questions/{question}/up', [AdminQuestionController::class, 'moveUp'])->name('questions.up');
    Route::post('quizzes/{quiz}/questions/{question}/down', [AdminQuestionController::class, 'moveDown'])->name('questions.down');

    Route::post('quizzes/{quiz}/questions/{question}/answers', [AdminAnswerController::class, 'store'])->name('answers.store');
    Route::put('quizzes/{quiz}/questions/{question}/answers/{answer}', [AdminAnswerController::class, 'update'])->name('answers.update');
    Route::delete('quizzes/{quiz}/questions/{question}/answers/{answer}', [AdminAnswerController::class, 'destroy'])->name('answers.destroy');

    Route::get('grading', [AdminGradingController::class, 'index'])->name('grading.index');
    Route::get('grading/{response}', [AdminGradingController::class, 'edit'])->name('grading.edit');
    Route::put('grading/{response}', [AdminGradingController::class, 'update'])->name('grading.update');
});
