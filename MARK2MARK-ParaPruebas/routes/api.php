<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::apiResource('clubs', ClubController::class);

Route::get('admin/atletas', [AthleteController::class, 'getAll']);
Route::get('admin/atletas/{id}', [AthleteController::class, 'getById']);
Route::post('admin/atletas', [AthleteController::class, 'create']);
Route::put('admin/atletas/{id}', [AthleteController::class, 'update']);
Route::delete('admin/atletas/{id}', [AthleteController::class, 'delete']);

// Route::get('/admin/clubes', function () {
//     return response()->json(['message' => 'clubes OK']);
// });

Route::get('admin/clubes', [ClubController::class, 'getAll']);
Route::get('admin/clubes/{id}', [ClubController::class, 'getById']);
Route::post('admin/clubes', [ClubController::class, 'create']);
Route::put('admin/clubes/{id}', [ClubController::class, 'update']);
Route::delete('admin/clubes/{id}', [ClubController::class, 'delete']);



//Route::apiResource('competitions', CompetitionController::class);
Route::get('competitions', [CompetitionController::class, 'index']);
Route::get('competitions/{id}', [CompetitionController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/competitions', [CompetitionController::class, 'store']);
    Route::put('/competitions/{id}', [CompetitionController::class, 'update']);
    Route::delete('/competitions/{id}', [CompetitionController::class, 'destroy']);
});
Route::get('/calendar/competitions', [CompetitionController::class, 'calendar']);

Route::get('/ping', function () {
    return response()->json(['message' => 'API OK']);
});
