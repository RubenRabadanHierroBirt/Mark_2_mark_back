<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAthleteRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => 'nullable|exists:usuarios,id',
            'club_actual_id' => 'nullable|exists:clubs,id',
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'status' => 'nullable|in:Activo,Pendiente,Suspendido',
            'username' => 'sometimes|string|max:50|unique:usuarios,username',
            'usuario' => 'sometimes|string|max:50|unique:usuarios,username',
            'password' => 'sometimes|string|min:6|max:255',
            'club_nombre' => 'sometimes|string|max:100',
        ];
    }
}
