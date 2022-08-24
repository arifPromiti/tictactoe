<?php

use App\Http\Controllers\GameController;
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

Route::get('/', [GameController::class, 'index']);
Route::post('/startNewGame/', [GameController::class, 'startGame']);
Route::post('/set-move/', [GameController::class, 'createMove']);
Route::get('/check-turn/', [GameController::class, 'checkTurn']);
Route::get('/load-game-Board/', [GameController::class, 'gameBoard'])->name('Game.bord');
