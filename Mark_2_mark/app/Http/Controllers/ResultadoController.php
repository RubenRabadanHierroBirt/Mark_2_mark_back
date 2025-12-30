<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    /**
     * Muestra una lista de todos los resultados.
     */
    public function index()
    {
        return Resultado::all();
    }

    /**
     * Guarda un nuevo resultado de competición en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'required|integer|exists:competiciones,id',
            'id_registro_atletico' => 'required|integer|exists:atletas,id', // Note: Model says id_registro_atletico maps to Atleta class but name suggests RegistrosAtletum. Model relationship says 'id_registro_atletico' belongsTo Atleta. Check Model again?
            // Checking model Resultado: public function atleta() { return $this->belongsTo(Atleta::class, 'id_registro_atletico'); }
            // So it IS an integer pointing to athletes.
            'tipo_evento' => 'required|string|max:100',
            'categoria' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:50',
            'posicion' => 'nullable|integer',
            'wind_speed' => 'nullable|numeric',
        ]);

        $resultado = Resultado::create($validatedData);

        return response()->json($resultado, 201);
    }

    /**
     * Muestra los detalles de un resultado específico.
     */
    public function show(Resultado $resultado)
    {
        return $resultado;
    }

    /**
     * Actualiza un resultado existente en la base de datos.
     */
    public function update(Request $request, Resultado $resultado)
    {
        $validatedData = $request->validate([
            'id_competicion' => 'sometimes|required|integer|exists:competiciones,id',
            'id_registro_atletico' => 'sometimes|required|integer|exists:atletas,id',
            'tipo_evento' => 'sometimes|required|string|max:100',
            'categoria' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:50',
            'posicion' => 'nullable|integer',
            'wind_speed' => 'nullable|numeric',
        ]);

        $resultado->update($validatedData);

        return response()->json($resultado, 200);
    }

    /**
     * Elimina un resultado de la base de datos.
     */
    public function destroy(Resultado $resultado)
    {
        $resultado->delete();

        return response()->json(null, 204);
    }
}
