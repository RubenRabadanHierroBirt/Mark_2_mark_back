<?php

namespace App\Http\Controllers;

use App\Models\AtletaClub;
use Illuminate\Http\Request;

class AtletaClubController extends Controller
{
    /**
     * Muestra una lista de las relaciones entre atletas y clubes.
     */
    public function index()
    {
        return AtletaClub::all();
    }

    /**
     * Guarda una nueva relación entre atleta y club.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_atleta' => 'required|integer|exists:atletas,id',
            'id_club' => 'required|integer|exists:clubs,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $atletaClub = AtletaClub::create($validatedData);

        return response()->json($atletaClub, 201);
    }

    /**
     * Muestra los detalles de una relación específica entre atleta y club.
     */
    public function show(AtletaClub $atletaClub)
    {
        return $atletaClub;
    }

    /**
     * Actualiza una relación existente entre atleta y club.
     */
    public function update(Request $request, AtletaClub $atletaClub)
    {
        $validatedData = $request->validate([
            'id_atleta' => 'sometimes|required|integer|exists:atletas,id',
            'id_club' => 'sometimes|required|integer|exists:clubs,id',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $atletaClub->update($validatedData);

        return response()->json($atletaClub, 200);
    }

    /**
     * Elimina una relación entre atleta y club de la base de datos.
     */
    public function destroy(AtletaClub $atletaClub)
    {
        $atletaClub->delete();

        return response()->json(null, 204);
    }
}
