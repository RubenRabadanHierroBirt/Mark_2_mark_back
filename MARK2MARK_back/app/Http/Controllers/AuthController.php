<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de que tu modelo de usuario se llame así

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Recogemos lo que envía Angular.
        $loginInput = $request->input('email');
        $password = $request->input('password');

        if (!$loginInput || !$password) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Faltan datos'
            ], 400);
        }

        // Comprobamos si el texto es un mail o username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Intentamos el login usando el campo dinámico ($fieldType)
        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password])) {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Creamos el token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Login correcto',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'rol' => $user->rol
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'ERROR',
            'message' => 'Credenciales incorrectas (Usuario/Email o contraseña no válidos)'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
