<?php

namespace App\Http\Controllers;

use App\DTOs\Result\ResultsDTO;
use App\Http\Requests\CreateResultsRequest;
use App\Http\Requests\UpdateResultsRequest;
use App\Models\Results;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function getAll()
    {
        $results = Results::with(['competition', 'athlete'])->get();
        $dtos = [];

        foreach ($results as $result) {
            $dtos[] = new ResultsDTO($result);
        }

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultados obtenidos correctamente',
            $dtos
        );
    }

    public function getById($id)
    {
        $result = Results::with(['competition', 'athlete'])->find($id);

        if (!$result) {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Resultado no encontrado',
                null
            );
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
        $results = Results::with('competition')
            ->where('id_atleta', $athleteId)
            ->get();

        $dtos = [];

        foreach ($results as $result) {
            $dtos[] = new ResultsDTO($result);
        }

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
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Resultado no encontrado',
                null
            );
        }

        $result->update($request->validated());

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
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Resultado no encontrado',
                null
            );
        }

        $result->delete();

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Resultado eliminado correctamente',
            new ResultsDTO($result)
        );
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
