<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\FederacionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ENDOPINT PUBLICOS -------------------------------------------

Route::post('login', [AuthController::class, 'login']);
Route::get('/competitions', [CompetitionController::class, 'getAll']);
Route::get('/external-news', [NewsController::class, 'getExternalNews']);
Route::get('/noticias', [NewsController::class, 'getAll']);
Route::get('/results', [ResultsController::class, 'getAll']);


// ENDPOINTS PARA ATLETAS --------------------------------------

Route::middleware(['auth:sanctum', 'role:ATLETA'])->group(function () {
    Route::get('/atleta/dashboard', [AthleteController::class, 'getDashboard']);
    Route::put('/athlete/update', [AthleteController::class, 'updateProfile']);
});
    

// ENDPOINTS PARA CLUBS ----------------------------------------

Route::middleware(['auth:sanctum', 'role:CLUB'])->group(function () {
    Route::get('/club/dashboard', [ClubController::class, 'getDashboard']);
    Route::get('/admin/clubes/{id}', [ClubController::class, 'getById']);

    Route::get('/competition/{id}/inscripcion-data', [CompetitionController::class, 'getInscripcionData']);
    Route::post('/competition/registrar-atleta', [CompetitionController::class, 'registrarAtleta']);
    Route::delete('/competition/registro/{id}', [CompetitionController::class, 'eliminarInscripcion']);
});


// ENDPOINTS PARA FEDERACION -----------------------------------

Route::middleware(['auth:sanctum', 'role:FEDERACION'])->group(function () {
    Route::get('/admin/dashboard', [FederacionController::class, 'getDashboard']);
    
    Route::get('/admin/clubes', [ClubController::class, 'getAll']);
    Route::post('/admin/clubes', [ClubController::class, 'create']);
    Route::delete('/admin/clubes/{id}', [ClubController::class, 'delete']);
    
    Route::post('/admin/competitions', [CompetitionController::class, 'create']);
    Route::put('/admin/competitions/{id}', [CompetitionController::class, 'update']);
    Route::delete('/admin/competitions/{id}', [CompetitionController::class, 'delete']);
    Route::get('/admin/inscripcion/excel/{id}', [CompetitionController::class, 'downloadInscripcionExcel']);
    
    Route::post('/admin/noticias', [NewsController::class, 'create']);
    
    
    Route::get('/admin/report/{tipo}/excel', [ReportController::class, 'downloadExcel']);
});


// ENDPOINT PARA CLUB Y FEDERACION -------------------------------

Route::middleware(['auth:sanctum', 'role:CLUB,FEDERACION'])->group(function () {
    Route::get('admin/atletas', [AthleteController::class, 'getAll']);
    Route::post('/admin/atletas', [AthleteController::class, 'create']);
    Route::put('/admin/atletas/{id}', [AthleteController::class, 'update']);
    Route::delete('/admin/atletas/{id}', [AthleteController::class, 'delete']);
    
    Route::put('admin/clubes/{id}', [ClubController::class, 'update']);
    
    Route::get('/admin/competitions', [CompetitionController::class, 'getAll']);
});

// ENDPOINTS PARA ATLETA, CLUB Y FEDERACION ----------------------

Route::middleware(['auth:sanctum', 'role:ATLETA,CLUB,FEDERACION'])->group(function () {

        Route::get('/results/competition/{id}/excel', [ResultsController::class, 'downloadByCompetitionExcel']);
});
