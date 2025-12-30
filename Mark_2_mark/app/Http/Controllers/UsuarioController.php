<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        return Usuario::all();
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,username',
            'password' => 'required|string|min:8',
            'email' => 'nullable|email|max:255|unique:usuarios,email',
            'rol' => 'required|string|max:50',
            'creado_el' => 'nullable|date',
            'desactivado' => 'nullable|boolean',
            'imagen' => 'nullable|image|max:16384', // Max 16MB
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = file_get_contents($request->file('imagen')->getRealPath());
        }

        $usuario = Usuario::create($validatedData);

        return response()->json($usuario, 201);
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show(Usuario $usuario)
    {
        return $usuario;
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $validatedData = $request->validate([
            'username' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('usuarios')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8', // Allow password update optionally
            'email' => ['nullable', 'email', 'max:255', Rule::unique('usuarios')->ignore($usuario->id)],
            'rol' => 'sometimes|required|string|max:50',
            'creado_el' => 'nullable|date',
            'desactivado' => 'nullable|boolean',
            'imagen' => 'nullable|image|max:16384', // Max 16MB
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = file_get_contents($request->file('imagen')->getRealPath());
        }

        $usuario->update($validatedData);

        return response()->json($usuario, 200);
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json(null, 204);
    }
}
