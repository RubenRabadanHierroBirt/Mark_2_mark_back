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

// ENDPOINTS PARA LOGIN Y LOGUOT
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// ENDOPINT PUBLICOS -------------------------------------------

Route::get('/competitions', [CompetitionController::class, 'getAll']);
Route::get('/external-news', [NewsController::class, 'getExternalNews']);
Route::get('/noticias', [NewsController::class, 'getAll']);
Route::get('/results', [ResultsController::class, 'getAll']);




// ENDPOINTS PARA ATLETAS --------------------------------------

Route::middleware(['auth:sanctum', 'role:ATLETA'])->group(function () {
    Route::get('/atleta/dashboard', [AthleteController::class, 'getDashboard']);
    Route::put('/athlete/update', [AthleteController::class, 'updateProfile']);// ATLETA CLUB FEDERACION

});




// ENDPOINTS PARA CLUBS ----------------------------------------

Route::middleware(['auth:sanctum', 'role:CLUB'])->group(function () {
    Route::get('/club/dashboard', [ClubController::class, 'getDashboard']);
    
    Route::get('/competition/{id}/inscripcion-data', [CompetitionController::class, 'getInscripcionData']);
    Route::post('/competition/registrar-atleta', [CompetitionController::class, 'registrarAtleta']);
    Route::delete('/competition/registro/{id}', [CompetitionController::class, 'eliminarInscripcion']);
});





// ENDPOINTS PARA FEDERACION -----------------------------------

Route::middleware(['auth:sanctum', 'role:FEDERACION'])->group(function () {
    Route::get('/admin/dashboard', [FederacionController::class, 'getDashboard']);
    
    Route::get('admin/clubes', [ClubController::class, 'getAll']);
    Route::post('admin/clubes', [ClubController::class, 'create']);
    Route::delete('admin/clubes/{id}', [ClubController::class, 'delete']);
    
    Route::post('/admin/competitions', [CompetitionController::class, 'create']);
    Route::put('/admin/competitions/{id}', [CompetitionController::class, 'update']);
    Route::delete('/admin/competitions/{id}', [CompetitionController::class, 'delete']);
    Route::get('/admin/inscripcion/excel/{id}', [CompetitionController::class, 'downloadInscripcionExcel']);
    
    Route::get('/admin/noticias/{id}', [NewsController::class, 'getById']);//
    Route::post('/admin/noticias', [NewsController::class, 'create']);//
    Route::put('/admin/noticias/{id}', [NewsController::class, 'update']);//
    Route::delete('/admin/noticias/{id}', [NewsController::class, 'delete']);//
    
    Route::get('/admin/report/{tipo}/excel', [ReportController::class, 'downloadExcel']);// FEDERACION
});




// ENDPOINT PARA CLUB Y FEDERACION -------------------------------

Route::middleware(['auth:sanctum', 'role:CLUB,FEDERACION'])->group(function () {
    Route::get('admin/atletas', [AthleteController::class, 'getAll']); // club y federacion
    Route::post('/admin/atletas', [AthleteController::class, 'create']);// CLUB Y FEDERACION
    Route::delete('/admin/atletas/{id}', [AthleteController::class, 'delete']);// CLUB Y FEDERACION
    
    Route::put('admin/clubes/{id}', [ClubController::class, 'update']);
    
    Route::get('/admin/competitions', [CompetitionController::class, 'getAll']);// federacion, club
});





// ENDPOINTS PARA ATLETA, CLUB Y FEDERACION ----------------------

Route::middleware(['auth:sanctum', 'role:ATLETA,CLUB,FEDERACION'])->group(function () {
        Route::put('/admin/atletas/{id}', [AthleteController::class, 'update']);

        Route::get('/results/competition/{id}/excel', [ResultsController::class, 'downloadByCompetitionExcel']);
});



// REPASAR ----------------------------------

// Route::get('/atleta/dashboard/resultados/excel', [AthleteController::class, 'downloadUltimosResultadosExcel']);//

// Route::get('admin/clubes/{id}', [ClubController::class, 'getById']);//


// // ENDPOINT PRUEBA PING
// Route::get('/ping', function () {
//     return response()->json(['message' => 'API OK']);//
// });
