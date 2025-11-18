<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quizzes/{quiz}', [QuizController::class, 'submit'])->name('quizzes.submit');
Route::get('/quizzes/{quiz}/results/{attempt}', [QuizController::class, 'result'])->name('quizzes.results');

// Future AdminQuizController routes will be registered under the "admin" prefix.
