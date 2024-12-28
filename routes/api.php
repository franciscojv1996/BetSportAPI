<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SportsController;
use App\Http\Controllers\CasinoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!  Scores
|
*/

Route::get('/sports', [SportsController::class, 'index']);
Route::get('/sports/associations', [SportsController::class, 'associations']);
Route::get('/sports/odds', [SportsController::class, 'associationsOdds']);
Route::get('/sports/scores', [SportsController::class, 'associationsScores']); 
Route::get('/sports/events', [SportsController::class, 'associationsEvents']);
Route::get('/sports/oddsEvents', [SportsController::class, 'associationsOddsEvents']);