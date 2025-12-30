<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use Illuminate\Http\Request;

class AtletaController extends Controller
{
    /**
     * Muestra una lista de todos los atletas.
     */
    public function index()
    {
        return Atleta::all();
    }

    /**
     * Muestra el formulario para crear un nuevo atleta (no usado en API).
     */
    public function create()
    {
        // Not used in API context usually, but kept if user wants views later.
    }

    /**
     * Guarda un nuevo atleta en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'nullable|integer', // Check exists:usuarios,id if needed
            'club_actual_id' => 'nullable|integer', // Check exists:clubs,id if needed
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $atleta = Atleta::create($validatedData);

        return response()->json($atleta, 201);
    }

    /**
     * Muestra los detalles de un atleta específico.
     */
    public function show(Atleta $atleta)
    {
        return $atleta;
    }

    /**
     * Muestra el formulario para editar un atleta (no usado en API).
     */
    public function edit(Atleta $atleta)
    {
        // Not used in API context
    }

    /**
     * Actualiza un atleta existente en la base de datos.
     */
    public function update(Request $request, Atleta $atleta)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'nullable|integer',
            'club_actual_id' => 'nullable|integer',
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $atleta->update($validatedData);

        return response()->json($atleta, 200);
    }

    /**
     * Elimina un atleta de la base de datos.
     */
    public function destroy(Atleta $atleta)
    {
        $atleta->delete();

        return response()->json(null, 204);
    }
}
