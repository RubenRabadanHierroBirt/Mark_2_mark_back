<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ENDPOINTS PARA LOGIN Y LOGUOT
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ENDPOINTS ATLETAS

Route::get('admin/atletas', [AthleteController::class, 'getAll']);
Route::get('admin/atletas/{id}', [AthleteController::class, 'getById']);
// Route::post('admin/atletas', [AthleteController::class, 'create']);
// Route::put('admin/atletas/{id}', [AthleteController::class, 'update']);
// Route::delete('admin/atletas/{id}', [AthleteController::class, 'delete']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/atletas', [AthleteController::class, 'create']);
    Route::put('/admin/atletas/{id}', [AthleteController::class, 'update']);
    Route::delete('/admin/atletas/{id}', [AthleteController::class, 'delete']);
});


// ENDPOINT CLUBES ----------- comprobar endpoint con autenticación en atletas y competiciones. Si funciona, añadir aquí tambn

Route::get('admin/clubes', [ClubController::class, 'getAll']);
Route::get('admin/clubes/{id}', [ClubController::class, 'getById']);
Route::post('admin/clubes', [ClubController::class, 'create']);
Route::put('admin/clubes/{id}', [ClubController::class, 'update']);
Route::delete('admin/clubes/{id}', [ClubController::class, 'delete']);
// Route::get('/admin/clubes', function () {        return response()->json(['message' => 'clubes OK']);         });


// ENDPOINT COMPETICIONES 

Route::get('/admin/competitions', [CompetitionController::class, 'getAll']);
Route::get('/admin/competitions/{id}', [CompetitionController::class, 'getById']);
// Route::post('/admin/competitions', [CompetitionController::class, 'create']);
// Route::put('/admin/competitions/{id}', [CompetitionController::class, 'update']);
// Route::delete('/admin/competitions/{id}', [CompetitionController::class, 'delete']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/competitions', [CompetitionController::class, 'create']);
    Route::put('/admin/competitions/{id}', [CompetitionController::class, 'update']);
    Route::delete('/admin/competitions/{id}', [CompetitionController::class, 'delete']);
});



Route::get('/calendar/competitions', [CompetitionController::class, 'calendar']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [AthleteController::class, 'getDashboard']);
});



// ENDPOINT PRUEBA PING
Route::get('/ping', function () {
    return response()->json(['message' => 'API OK']);
});