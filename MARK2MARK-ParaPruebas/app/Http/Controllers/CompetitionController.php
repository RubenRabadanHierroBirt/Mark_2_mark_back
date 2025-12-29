<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Competition;
use App\DTOs\Competition\CompetitionDTO;
use App\Http\Requests\CreateCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;


// FALTA COMPROBAR QUE LAS VALIDACIONES DE LAS REQUEST EN CREATE Y UPDATE FUNCIONEN
class CompetitionController extends Controller
{
    public function getAll()
    {
        $competitions = Competition::all();
        $dtosCompetitions = [];

        foreach ($competitions as $competition) {
            $dtosCompetitions[] = new CompetitionDTO($competition);
        }

        if ($dtosCompetitions) {
            return $this->sendResponse(
                'SUCCESS',
                200,
                'Contenido mostrado correctamente',
                $dtosCompetitions
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al acceder al contenido',
                null
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