<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Route::post('/polls', [PollController::class, 'store']);     // create poll
Route::get('/polls', [PollController::class, 'index']);      // list polls
Route::get('/polls/{poll}', [PollController::class, 'show']); // get single poll

Route::post('/polls/{poll}/vote', [VoteController::class, 'store']); // vote
Route::get('/polls/{poll}/results', [VoteController::class, 'results']); // results