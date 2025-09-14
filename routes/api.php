<?php

use App\Http\Controllers\Api\RecordController;
use App\Http\Controllers\Api\StatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    // Records
    Route::get('records', [RecordController::class, 'index']);
    Route::post('records', [RecordController::class, 'store']);
    Route::get('records/{date}', [RecordController::class, 'show']);
    Route::delete('records/{date}', [RecordController::class, 'destroy']);

    // Stats
    Route::get('stats', [StatController::class, 'index']);
    Route::post('stats/calculate', [StatController::class, 'calculate']);
});
