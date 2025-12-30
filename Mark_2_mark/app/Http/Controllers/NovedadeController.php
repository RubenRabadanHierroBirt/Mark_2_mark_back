<?php

namespace App\Http\Controllers;

use App\Models\Novedade;
use Illuminate\Http\Request;

class NovedadeController extends Controller
{
    /**
     * Muestra una lista de todas las novedades.
     */
    public function index()
    {
        return Novedade::all();
    }

    /**
     * Guarda una nueva novedad en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fecha' => 'required|date',
            'contenido' => 'required|string',
            'tipo' => 'required|string|max:50',
        ]);

        $novedade = Novedade::create($validatedData);

        return response()->json($novedade, 201);
    }

    /**
     * Muestra los detalles de una novedad específica.
     */
    public function show(Novedade $novedade)
    {
        return $novedade;
    }

    /**
     * Actualiza una novedad existente en la base de datos.
     */
    public function update(Request $request, Novedade $novedade)
    {
        $validatedData = $request->validate([
            'fecha' => 'sometimes|required|date',
            'contenido' => 'sometimes|required|string',
            'tipo' => 'sometimes|required|string|max:50',
        ]);

        $novedade->update($validatedData);

        return response()->json($novedade, 200);
    }

    /**
     * Elimina una novedad de la base de datos.
     */
    public function destroy(Novedade $novedade)
    {
        $novedade->delete();

        return response()->json(null, 204);
    }
}
