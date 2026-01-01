<?php

namespace App\Http\Controllers;

use App\Models\Results;
use Illuminate\Http\Request;
use App\DTOs\Results\ResultsDTO;
use App\Http\Requests\CreateResultsRequest;
use App\Http\Requests\UpdateResultsRequest;

class ResultsController extends Controller
{
    // Obtener todos los resultados (Transformados a DTO)
    public function getAll()
    {
        // Cargamos las relaciones para que el DTO tenga datos de atleta y competición
        $results = Results::with(['competition', 'athlete'])->get();

        // Usamos map para transformar la colección entera
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
        $result = Results::with(['competition', 'athlete'])->find($id);

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
        $results = Results::with('competition')
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
        
        // Recargamos relaciones por si queremos devolver el nombre del atleta recién creado
        $result->load(['athlete', 'competition']);

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
        $result->load(['athlete', 'competition']);

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
            new ResultsDTO($result) // Devolvemos lo que se borró (opcional)
        );
    }

    // Respuesta Estándar
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