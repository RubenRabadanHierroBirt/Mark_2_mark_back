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
            'code' => 'required|string|max:20|unique:clubs,code',
            'name' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100',
            'estado' => 'nullable|in:Activo,Pendiente,Suspendido',
            'codigo_postal' => 'nullable|integer',
            'localidad' => 'nullable|string|max:255',
        ];
    }
}
