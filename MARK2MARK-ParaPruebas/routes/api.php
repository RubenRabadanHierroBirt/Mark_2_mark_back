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




// ENDPOINTS ATLETAS

Route::get('admin/atletas/{id}', [AthleteController::class, 'getById']);
// Route::post('admin/atletas', [AthleteController::class, 'create']);
// Route::put('admin/atletas/{id}', [AthleteController::class, 'update']);
// Route::delete('admin/atletas/{id}', [AthleteController::class, 'delete']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/atletas', [AthleteController::class, 'getAll']);
    Route::post('/admin/atletas', [AthleteController::class, 'create']);
    Route::put('/admin/atletas/{id}', [AthleteController::class, 'update']);
    Route::delete('/admin/atletas/{id}', [AthleteController::class, 'delete']);
    //Route::get('/atleta/dashboard', [AthleteController::class, 'getDashboard']);
    Route::get('/atleta/dashboard/resultados/excel', [AthleteController::class, 'downloadUltimosResultadosExcel']);
});








// ENDPOINT CLUBES ----------- comprobar endpoint con autenticación en atletas y competiciones. Si funciona, añadir aquí tambn

Route::get('admin/clubes', [ClubController::class, 'getAll']);
Route::get('admin/clubes/{id}', [ClubController::class, 'getById']);
Route::post('admin/clubes', [ClubController::class, 'create']);
Route::put('admin/clubes/{id}', [ClubController::class, 'update']);
Route::delete('admin/clubes/{id}', [ClubController::class, 'delete']);

// Route::get('/admin/clubes', function () {        return response()->json(['message' => 'clubes OK']);         });











// ENDPOINT FEDERACION

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/dashboard', [FederacionController::class, 'getDashboard']);
});







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

    // --- NUEVAS RUTAS PARA INSCRIPCIÓN DE CLUBES ---
    // 1. Cargar la tabla del modal (Atletas del club + estado inscripción)
    Route::get('/competition/{id}/inscripcion-data', [CompetitionController::class, 'getInscripcionData']);

    // 2. Inscribir a un atleta (Click en "Añadir")
    Route::post('/competition/registrar-atleta', [CompetitionController::class, 'registrarAtleta']);

    // 3. Quitar inscripción (Click en "Eliminar")
    Route::delete('/competition/registro/{id}', [CompetitionController::class, 'eliminarInscripcion']);
});












// ENDPOINTS NEWS
Route::get('/noticias', [NewsController::class, 'getAll']);
Route::get('/noticias/{id}', [NewsController::class, 'getById']);
Route::get('/admin/noticias', [NewsController::class, 'getAll']);
Route::get('/admin/noticias/{id}', [NewsController::class, 'getById']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/noticias', [NewsController::class, 'create']);
    Route::put('/admin/noticias/{id}', [NewsController::class, 'update']);
    Route::delete('/admin/noticias/{id}', [NewsController::class, 'delete']);
});

Route::get('/calendar/competitions', [CompetitionController::class, 'calendar']);



Route::middleware(['auth:sanctum', 'role:ATLETA'])->group(function () {
    Route::get('/atleta/dashboard', [AthleteController::class, 'getDashboard']);
});

Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/dashboard', [AthleteController::class, 'getDashboard']);
    Route::put('/athlete/update', [AthleteController::class, 'updateProfile']);
    Route::get('/club/dashboard', [ClubController::class, 'getDashboard']);
    Route::get('/admin/dashboard', [FederacionController::class, 'getDashboard']);
    Route::get('/admin/report/{tipo}/excel', [ReportController::class, 'downloadExcel']);
    Route::get('/admin/report/{tipo}', [ReportController::class, 'download']);
    Route::get('/results/competition/{id}/excel', [ResultsController::class, 'downloadByCompetitionExcel']);
});









// ENDPOINTS RESULTADOS (CLASIFICACIONES)
Route::get('/results', [ResultsController::class, 'getAll']);
Route::get('/results/athlete/{id}', [ResultsController::class, 'getByAthlete']); // Por si la necesitas luego

//Para todos los usuarios 
Route::get('/competitions', [CompetitionController::class, 'getAll']);






// ENDPOINT PRUEBA PING
Route::get('/ping', function () {
    return response()->json(['message' => 'API OK']);
});
