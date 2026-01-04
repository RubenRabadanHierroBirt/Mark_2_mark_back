<?php

namespace App\Http\Controllers;

use App\Models\Results;
use Illuminate\Http\Request;
use App\DTOs\Results\ResultsDTO;
use App\Http\Requests\CreateResultsRequest;
use App\Http\Requests\UpdateResultsRequest;

class ResultsController extends Controller
{

public function getAll()
{
    $results = Results::with(['competition', 'athlete.club'])->get();

    $timeBasedEvents = [
        '60m', '100m', '200m', '400m',
        '800m', '1500m', '5000m', '10000m',
        '110mh', '400mh'
    ];

    $bestResults = $results
        ->groupBy(fn ($result) => $result->id_atleta . '-' . $result->tipo_evento)
        ->map(function ($group) use ($timeBasedEvents) {

            $tipoEvento = $group->first()->tipo_evento;

            // AquÃ­ van las carreras, el mejor registro es el menor, podemos cambiar la pruebas del array de arriba. Los he cambiado en la BBDD y los dejo asÃ­
            if (in_array($tipoEvento, $timeBasedEvents)) {
                return $group
                    ->sortBy(fn ($r) => (float) $r->marca)
                    ->first();
            }

            // AquÃ­ van el resto de pruebas, los concursos. El mejor registro es el mayor
            return $group
                ->sortByDesc(fn ($r) => (float) $r->marca)
                ->first();
        })
        ->filter()
        ->values();


    $dtos = $bestResults->map(function ( Results $result) {
        return new ResultsDTO($result);
    });

    return $this->sendResponse(
        'SUCCESS',
        200,
        'ClasificaciÃ³n obtenida correctamente',
        $dtos
    );
}


    // Obtener todos los resultados (Transformados a DTO)
    public function getAllRaw()
    {
        // Cargamos las relaciones para que el DTO tenga datos de atleta y competiciÃ³n
        $results = Results::with(['competition', 'athlete.club'])->get();

        // Usamos map para transformar la colecciÃ³n entera
        $dtos = $results->map(function ($result) {
            return new ResultsDTO($result);
        });

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultados obtenidos correctamente',
            $dtos
        );
    }

    // Obtener por ID
    public function getById($id)
    {
        $result = Results::with(['competition', 'athlete.club'])->find($id);

        if (!$result) {
            return $this->sendResponse('NO SUCCESS', 404, 'Resultado no encontrado', null);
        }

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultado obtenido correctamente',
            new ResultsDTO($result)
        );
    }

    // Obtener por Atleta
    public function getByAthlete($athleteId)
    {
        $results = Results::with(['competition', 'athlete.club'])
            ->where('id_atleta', $athleteId)
            ->get();

        $dtos = $results->map(function ($result) {
            return new ResultsDTO($result);
        });

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultados del atleta obtenidos correctamente',
            $dtos
        );
    }

    // Crear Resultado
    public function create(CreateResultsRequest $request)
    {
        $result = Results::create($request->validated());
        
        // Recargamos relaciones por si queremos devolver el nombre del atleta reciÃ©n creado
        $result->load(['athlete.club', 'competition']);

        return $this->sendResponse(
            'SUCCESS',
            201,
            'Resultado creado correctamente',
            new ResultsDTO($result)
        );
    }

    // Actualizar Resultado
    public function update(UpdateResultsRequest $request, $id)
    {
        $result = Results::find($id);

        if (!$result) {
            return $this->sendResponse('NO SUCCESS', 404, 'Resultado no encontrado', null);
        }

        $result->update($request->validated());
        
        // Recargamos relaciones para el DTO
        $result->load(['athlete.club', 'competition']);

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultado actualizado correctamente',
            new ResultsDTO($result)
        );
    }

    // Eliminar Resultado
    public function delete($id)
    {
        $result = Results::find($id);

        if (!$result) {
            return $this->sendResponse('NO SUCCESS', 404, 'Resultado no encontrado', null);
        }

        $result->delete();

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultado eliminado correctamente',
            new ResultsDTO($result) // Devolvemos lo que se borrÃ³ (opcional)
        );
    }

    // Respuesta EstÃ¡ndar
    protected function sendResponse($status, $cod, $mensaje, $data)
    {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}
