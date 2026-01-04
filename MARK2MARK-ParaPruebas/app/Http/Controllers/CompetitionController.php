<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;

use App\Models\Competition;
use App\Models\Athlete; 
use App\Models\AthleteRegistration; 
use App\DTOs\Competition\CompetitionDTO;
use App\Http\Requests\CreateCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;


// FALTA COMPROBAR QUE LAS VALIDACIONES DE LAS REQUEST EN CREATE Y UPDATE FUNCIONEN
class CompetitionController extends Controller
{
    public function getAll()
    {
        // 1. Obtenemos competiciones ordenadas
        $competitions = Competition::orderBy('created_at', 'desc')->get();
        
        $dtosCompetitions = [];

        foreach ($competitions as $competition) {
            
            // 2. Calculamos los contadores para esta competición
            $atletasCount = AthleteRegistration::where('id_competicion', $competition->id)
                                ->distinct('id_atleta')
                                ->count('id_atleta');

            $clubesCount = AthleteRegistration::where('id_competicion', $competition->id)
                                ->distinct('id_club')
                                ->count('id_club');

            // 3. INYECTAMOS los datos en el modelo temporalmente
            // Laravel permite crear propiedades al vuelo en los objetos
            $competition->total_atletas = $atletasCount;
            $competition->total_clubes = $clubesCount;

            // 4. Pasamos el modelo (con los datos extra) al DTO
            $dtosCompetitions[] = new CompetitionDTO($competition);
        }

        // 5. Devolvemos la respuesta usando tu método helper
        if ($dtosCompetitions) {
            return $this->sendResponse(
                'SUCCESS',
                200,
                'Contenido mostrado correctamente',
                $dtosCompetitions
            );
        } else {
            // Nota: Si no hay competiciones, devolver un array vacío suele ser mejor que un 404,
            // pero mantengo tu lógica original.
            return $this->sendResponse(
                'SUCCESS', 
                200, 
                'No hay competiciones aún', 
                []
            );
        }
    }

    public function getById($id)
    {
        $competition = Competition::find($id);

        if ($competition) {
            return $this->sendResponse(
                'SUCCESS',
                200,
                'Elemento mostrado correctamente',
                new CompetitionDTO($competition)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Competición no encontrada',
                null
            );
        }
    }

    public function create(CreateCompetitionRequest $request)
    {
        $competition = Competition::create($request->validated());

        return $this->sendResponse(
            'SUCCESS',
            201,
            'Competición creada correctamente',
            new CompetitionDTO($competition)
        );
    }

    public function update(UpdateCompetitionRequest $request, $id)
    {
        $competition = Competition::find($id);

        if ($competition) {
            $competition->update($request->validated());

            return $this->sendResponse(
                'SUCCESS',
                200,
                'Competición con ID ' . $id . ' actualizada correctamente',
                new CompetitionDTO($competition)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Competición no encontrada',
                null
            );
        }
    }

    public function delete($id)
    {
        $competition = Competition::find($id);

        if ($competition) {
            $competition->delete();

            return $this->sendResponse(
                'SUCCESS',
                200,
                'Competición eliminada correctamente',
                new CompetitionDTO($competition)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al eliminar la competición',
                null
            );
        }
    }

    /**
     * 1. GET: Cargar datos para el Modal de Inscripción
     * Devuelve tus atletas y marca cuáles ya están inscritos en esa competición.
     */
  public function getInscripcionData(Request $request, $competitionId)
    {
        $user = $request->user();
        $clubId = $user->club->id; // O $user->club_id según tu relación

        // 1. Obtenemos los atletas del club (Activos)
        $misAtletas = Athlete::where('club_actual_id', $clubId)
            ->where('status', 'Activo') 
            ->get();

        // 2. Mapeamos para añadir la info de inscripciones
        $data = $misAtletas->map(function ($atleta) use ($competitionId) {
            
            // Buscamos si este atleta tiene registros EN ESTA competición
            $inscripciones = AthleteRegistration::where('id_atleta', $atleta->id)
                                ->where('id_competicion', $competitionId)
                                ->get();

            return [
                'id' => $atleta->id,
                'nombre' => $atleta->nombre . ' ' . $atleta->apellidos,
                'sexo' => $atleta->sexo,
                'esta_inscrito' => $inscripciones->isNotEmpty(),
                
                // Devolvemos la lista de pruebas donde está apuntado (ej: 100m, Peso...)
                'inscripciones' => $inscripciones->map(function($inscripcion) {
                    return [
                        'id_registro' => $inscripcion->id,
                        'tipo_evento' => $inscripcion->tipo_evento
                    ];
                })
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * 2. POST: Inscribir a un atleta en una prueba específica
     */
    public function registrarAtleta(Request $request)
    {
        $user = $request->user();

        // 1. Validaciones básicas
        $validated = $request->validate([
            'id_competicion' => 'required|integer|exists:competiciones,id',
            'id_atleta' => 'required|integer|exists:atletas,id',
            'tipo_evento' => 'required|string',
        ]);

        // === NUEVA VALIDACIÓN: ESTADO DE LA COMPETICIÓN ===
        $competicion = Competition::find($validated['id_competicion']);
        if ($competicion->status !== 'Inscripcion') {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'La competición no admite inscripciones (Cerrada o Finalizada).'], 422);
        }
        // ==================================================

        // 2. Seguridad: Verificar que el atleta pertenece al club logueado
        $atleta = Athlete::where('id', $validated['id_atleta'])
                    ->where('club_actual_id', $user->club->id)
                    ->first();

        if (!$atleta) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'El atleta no pertenece a tu club'], 403);
        }

        // 3. Evitar duplicados
        $existe = AthleteRegistration::where('id_competicion', $validated['id_competicion'])
                    ->where('id_atleta', $validated['id_atleta'])
                    ->where('tipo_evento', $validated['tipo_evento'])
                    ->exists();

        if ($existe) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'El atleta ya está inscrito en esa prueba'], 409);
        }

        // 4. Crear registro
        $registro = AthleteRegistration::create([
            'id_competicion' => $validated['id_competicion'],
            'id_atleta' => $validated['id_atleta'],
            'id_club' => $user->club->id,
            'tipo_evento' => $validated['tipo_evento'],
            'fecha_inscripcion' => now(),
            'dorsal' => null 
        ]);

        return response()->json([
            'status' => 'SUCCESS',
            'mensaje' => 'Inscripción realizada',
            'data' => $registro
        ]);
    }

    /**
     * 3. DELETE: Quitar inscripción (Desapuntar)
     */
    public function eliminarInscripcion(Request $request, $idRegistro)
    {
        $user = $request->user();
        
        $registro = AthleteRegistration::find($idRegistro);

        if (!$registro) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'Inscripción no encontrada'], 404);
        }

        // === NUEVA VALIDACIÓN: ESTADO DE LA COMPETICIÓN ===
        // Buscamos la competición asociada al registro para ver si está cerrada
        $competicion = Competition::find($registro->id_competicion);
        if ($competicion && $competicion->status !== 'Inscripcion') {
             return response()->json(['status' => 'ERROR', 'mensaje' => 'No se puede borrar. La competición está cerrada.'], 422);
        }
        // ==================================================

        if ($user->rol !== 'CLUB' || $registro->id_club !== $user->club->id) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'No autorizado'], 403);
        }

        $registro->delete();

        return response()->json(['status' => 'SUCCESS', 'mensaje' => 'Inscripción eliminada correctamente']);
    }

    public function sendResponse($status, $cod, $mensaje, $data)
    {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}