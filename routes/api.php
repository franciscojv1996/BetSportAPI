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
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/sports', [SportsController::class, 'index']);
Route::get('/sports/soccer', [SportsController::class, 'soccer']);
Route::get('/sports/basketball', [SportsController::class, 'basketball']);

Route::get('/casino/game', [CasinoController::class, 'game']);
Route::get('/casino/game/{id}', [CasinoController::class, 'gameProvider']);
Route::get('/casino/provider', [CasinoController::class, 'provider']);
