<?php

use App\Http\Controllers\Draggable\CardController;
use App\Http\Controllers\Draggable\ColumnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::get('/columns', [ColumnController::class, 'index']);
    Route::post('/column', [ColumnController::class, 'store']);
    Route::delete('/column/{id}', [ColumnController::class, 'destroy']);

    Route::get('/cards', [CardController::class, 'index']);
    Route::post('/card', [CardController::class, 'store']);
    Route::put('/card/{id}', [CardController::class, 'update']);
    Route::post('/update-card-position', [CardController::class, 'updateCardPosition']);

