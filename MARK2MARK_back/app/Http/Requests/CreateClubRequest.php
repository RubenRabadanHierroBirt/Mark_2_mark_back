<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClubRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'id_usuario' => 'nullable|exists:usuarios,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clubs,email',
            'code' => 'required|unique:clubs,code',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:255',
            'localidad' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|integer',
            'estado' => 'nullable|in:Activo,Pendiente,Suspendido',
            'username' => 'sometimes|string|max:50|unique:usuarios,username',
            'usuario' => 'sometimes|string|max:50|unique:usuarios,username',
            'password' => 'sometimes|string|min:6|max:255',
        ];
    }
}
