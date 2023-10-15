<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\QuestionsController::class, 'index']);

Auth::routes();

Route::get('/home', [\App\Http\Controllers\QuestionsController::class, 'index'])->name('home');

Route::resource('questions', App\Http\Controllers\QuestionsController::class)->except('show');

Route::resource('questions.answers', \App\Http\Controllers\AnswersController::class)->except('create', 'show');

Route::get('/questions/{slug}', [\App\Http\Controllers\QuestionsController::class, 'show'])->name('questions.show');

Route::post('/answers/{answer}/accept', \App\Http\Controllers\AcceptAnswerController::class)->name('answers.accept');

Route::post('/questions/{question}/favorites', [\App\Http\Controllers\FavoritesController::class, 'store'])->name('questions.favorite');
Route::delete('/questions/{question}/favorites', [\App\Http\Controllers\FavoritesController::class, 'destroy'])->name('questions.unfavorite');

Route::post('/questions/{question}/vote', \App\Http\Controllers\VoteQuestionController::class);
Route::post('/answers/{answer}/vote', \App\Http\Controllers\VoteAnswerController::class);

Route::get('users',[\App\Http\Controllers\HomeController::class,'users'])->name('users.index');
Route::Post('users/{id}',[\App\Http\Controllers\HomeController::class,'updateUser'])->name('users.update');
Route::delete('users/{id}',[\App\Http\Controllers\HomeController::class,'destroy'])->name('users.destroy');
