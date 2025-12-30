<?php

namespace App\Http\Controllers;

use App\Models\RegistrosAtletum;
use Illuminate\Http\Request;

class RegistrosAtletumController extends Controller
{
    /**
     * Muestra una lista de todos los registros de atletas en competiciones.
     */
    public function index()
    {
        return RegistrosAtletum::all();
    }

    /**
     * Guarda un nuevo registro de atleta para una competición.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'required|integer|exists:competiciones,id',
            'id_atleta' => 'required|integer|exists:atletas,id',
            'id_club' => 'required|integer|exists:clubs,id',
            'tipo_evento' => 'nullable|string|max:100',
            'dorsal' => 'nullable|integer',
            'fecha_inscripcion' => 'nullable|date',
        ]);

        $registroAtletum = RegistrosAtletum::create($validatedData);

        return response()->json($registroAtletum, 201);
    }

    /**
     * Muestra los detalles de un registro de atleta específico.
     */
    public function show(RegistrosAtletum $registrosAtletum)
    {
        return $registrosAtletum;
    }

    /**
     * Actualiza un registro de atleta existente en la base de datos.
     */
    public function update(Request $request, RegistrosAtletum $registrosAtletum)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'sometimes|required|integer|exists:competiciones,id',
            'id_atleta' => 'sometimes|required|integer|exists:atletas,id',
            'id_club' => 'sometimes|required|integer|exists:clubs,id',
            'tipo_evento' => 'nullable|string|max:100',
            'dorsal' => 'nullable|integer',
            'fecha_inscripcion' => 'nullable|date',
        ]);

        $registrosAtletum->update($validatedData);

        return response()->json($registrosAtletum, 200);
    }

    /**
     * Elimina un registro de atleta de la base de datos.
     */
    public function destroy(RegistrosAtletum $registrosAtletum)
    {
        $registrosAtletum->delete();

        return response()->json(null, 204);
    }
}
