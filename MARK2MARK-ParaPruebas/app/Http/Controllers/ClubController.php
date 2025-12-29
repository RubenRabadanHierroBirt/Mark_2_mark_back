<?php

namespace App\Http\Controllers;

use App\DTOs\Club\ClubDTO;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    // FALTAN CREAR LAS VALIDACIONES PARA CREATE Y UPDATE, COMPROBAR SI FUNCIONAN LAS DE ATHLETE CON LA BBDD Y AÑADIRLAS AQUI
    public function getAll()
    {
        $clubs = Club::with('user')->get();
        $dtosClubs = [];

        foreach ($clubs as $club) {
            $dtosClubs[] = new ClubDTO($club);
        }

        if ($dtosClubs) {
            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Contenido mostrado correctamente';

            return $this->sendResponse($status, $cod, $mensaje, $dtosClubs);
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Error al acceder al contenido';

            return $this->sendResponse($status, $cod, $mensaje, null);
        }
    }
    
    public function create(Request $request)
    {
        $club = Club::create($request->all());

        if ($club) {
            return $this->sendResponse(
                $status = 'SUCCESS',
                $cod = 201,
                $mensaje = 'Elemento creado correctamente',
                new ClubDTO($club)
            );

        } else {

            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al crear el elemento',
                null
            );    
        }
    }
    
    public function getById(string $id)
    {
        $club = Club::with('user')->find($id);

        if ($club) {
            return $this->sendResponse(
                'SUCCESS',
                200,
                'Elemento mostrado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Club no encontrado',
                null
            );
        }    }

    public function update(Request $request, string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->update($request->all());

            return $this->sendResponse(
                'SUCCESS',
                200,
                'Elemento con ID ' . $id . ' actualizado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Club no encontrado',
                null
            );
        }
    }
    
    
    public function delete(string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->delete();

            return $this->sendResponse(
                'SUCCESS',
                200,
                'El siguiente elemento se ha eliminado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al eliminar el elemento',
                null
            );
        }
    }

    public function sendResponse($status, $cod, $mensaje, $data) {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}