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

    // Para obtener la mejor marca de cada atleta, tenemos que diferenciar las pruebas en las que la mejor sea el valor más bajo 
    // del campo marca (pruebas basadas en tiempo) y las que la mejor marca el la mayor (pruebas basadas en distancia)
    $timeBasedEvents = [
        '60m', '100m', '200m', '400m',
        '800m', '1500m', '5000m', '10000m',
        '110mh', '400mh'
    ];

    $bestResults = $results
        ->groupBy(fn ($result) => $result->id_atleta . '-' . $result->tipo_evento)
        ->map(function ($group) use ($timeBasedEvents) {

            $tipoEvento = $group->first()->tipo_evento;

            // Aquí­ van las carreras, el mejor registro es el menor, podemos cambiar la pruebas del array de arriba. Los he cambiado en la BBDD y los dejo así
            if (in_array($tipoEvento, $timeBasedEvents)) {
                return $group
                    ->sortBy(fn ($r) => (float) $r->marca)
                    ->first();
            }

            // Aquí­ van el resto de pruebas, los concursos. El mejor registro es el mayor
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
        'Clasificación obtenida correctamente',
        $dtos
    );
}


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
            new ResultsDTO($result)
        );
    }

    public function downloadByCompetitionExcel($competitionId)
    {
        $results = Results::with(['competition', 'athlete.club'])
            ->where('id_competicion', $competitionId)
            ->get();

        if ($results->isEmpty()) {
            return $this->sendResponse('NO SUCCESS', 404, 'No hay resultados para esta competicion', null);
        }

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Fecha', 'Competicion', 'Atleta', 'Club', 'Categoria', 'Marca', 'Posicion', 'Viento']);

        foreach ($results as $res) {
            $fecha = $res->competition ? \Carbon\Carbon::parse($res->competition->fecha)->format('d/m/y') : '';
            $competicion = $res->competition ? $res->competition->name : '';
            $atleta = $res->athlete ? $res->athlete->nombre : '';
            $club = ($res->athlete && $res->athlete->club) ? $res->athlete->club->name : '';
            fputcsv($handle, [
                $fecha,
                $competicion,
                $atleta,
                $club,
                $res->categoria,
                $res->marca,
                $res->posicion,
                $res->wind_speed
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="resultados_competicion_' . $competitionId . '.csv"'
        ]);
    }

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
