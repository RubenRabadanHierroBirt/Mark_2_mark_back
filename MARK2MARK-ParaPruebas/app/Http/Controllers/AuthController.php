<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de que tu modelo de usuario se llame así

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Recogemos lo que envía Angular.
        // OJO: En tu AuthService de Angular lo envías dentro del campo 'email', 
        // así que aquí lo recibimos como $request->email, aunque sea un nombre de usuario.
        $loginInput = $request->input('email');
        $password = $request->input('password');

        // 2. La validación básica (solo comprobamos que no estén vacíos)
        if (!$loginInput || !$password) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Faltan datos'
            ], 400);
        }

        // 3. LA MAGIA: Comprobamos si el texto parece un email o no
        // Si pasa el filtro de email, buscamos por 'email'. Si no, por 'username'.
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 4. Intentamos el login usando el campo dinámico ($fieldType)
        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password])) {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Creamos el token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Respuesta Éxito
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

        // 5. Respuesta Error
        return response()->json([
            'status' => 'ERROR',
            'message' => 'Credenciales incorrectas (Usuario/Email o contraseña no válidos)'
        ], 401);
    }

    // Opcional: Función para salir
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
