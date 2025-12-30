<?php

namespace App\Http\Controllers;

use App\Models\Competicione;
use Illuminate\Http\Request;

class CompeticioneController extends Controller
{
    /**
     * Muestra una lista de todas las competiciones.
     */
    public function index()
    {
        return Competicione::all();
    }

    /**
     * Guarda una nueva competición en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'fecha' => 'required|date',
            'organizador' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'revisado_federacion' => 'nullable|boolean',
            'creado_el' => 'nullable|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'fecha_limite' => 'nullable|date',
        ]);

        $competicione = Competicione::create($validatedData);

        return response()->json($competicione, 201);
    }

    /**
     * Muestra los detalles de una competición específica.
     */
    public function show(Competicione $competicione)
    {
        return $competicione;
    }

    /**
     * Actualiza una competición existente en la base de datos.
     */
    public function update(Request $request, Competicione $competicione)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'fecha' => 'sometimes|required|date',
            'organizador' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'revisado_federacion' => 'nullable|boolean',
            'creado_el' => 'nullable|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'fecha_limite' => 'nullable|date',
        ]);

        $competicione->update($validatedData);

        return response()->json($competicione, 200);
    }

    /**
     * Elimina una competición de la base de datos.
     */
    public function destroy(Competicione $competicione)
    {
        $competicione->delete();

        return response()->json(null, 204);
    }
}
