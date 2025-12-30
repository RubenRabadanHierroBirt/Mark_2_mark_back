<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Muestra una lista de todos los clubes.
     */
    public function index()
    {
        return Club::all();
    }

    /**
     * Guarda un nuevo club en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'nullable|integer|exists:usuarios,id',
            'code' => 'required|string|max:255|unique:clubs,code',
            'name' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:50',
            'codigo_postal' => 'nullable|integer',
            'localidad' => 'nullable|string|max:100',
        ]);

        $club = Club::create($validatedData);

        return response()->json($club, 201);
    }

    /**
     * Muestra los detalles de un club específico.
     */
    public function show(Club $club)
    {
        return $club;
    }

    /**
     * Actualiza un club existente en la base de datos.
     */
    public function update(Request $request, Club $club)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'nullable|integer|exists:usuarios,id',
            'code' => 'sometimes|required|string|max:255|unique:clubs,code,' . $club->id,
            'name' => 'sometimes|required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:50',
            'codigo_postal' => 'nullable|integer',
            'localidad' => 'nullable|string|max:100',
        ]);

        $club->update($validatedData);

        return response()->json($club, 200);
    }

    /**
     * Elimina un club de la base de datos.
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return response()->json(null, 204);
    }
}
