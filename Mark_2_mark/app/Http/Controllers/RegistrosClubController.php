<?php

namespace App\Http\Controllers;

use App\Models\RegistrosClub;
use Illuminate\Http\Request;

class RegistrosClubController extends Controller
{
    /**
     * Muestra una lista de todos los registros de clubes en competiciones.
     */
    public function index()
    {
        return RegistrosClub::all();
    }

    /**
     * Guarda un nuevo registro de club para una competición.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'required|integer|exists:competiciones,id',
            'id_club' => 'required|integer|exists:clubs,id',
            'fecha_registro' => 'nullable|date',
        ]);

        $registrosClub = RegistrosClub::create($validatedData);

        return response()->json($registrosClub, 201);
    }

    /**
     * Muestra los detalles de un registro de club específico.
     */
    public function show(RegistrosClub $registrosClub)
    {
        return $registrosClub;
    }

    /**
     * Actualiza un registro de club existente en la base de datos.
     */
    public function update(Request $request, RegistrosClub $registrosClub)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'sometimes|required|integer|exists:competiciones,id',
            'id_club' => 'sometimes|required|integer|exists:clubs,id',
            'fecha_registro' => 'nullable|date',
        ]);

        $registrosClub->update($validatedData);

        return response()->json($registrosClub, 200);
    }

    /**
     * Elimina un registro de club de la base de datos.
     */
    public function destroy(RegistrosClub $registrosClub)
    {
        $registrosClub->delete();

        return response()->json(null, 204);
    }
}
