<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClubRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => 'sometimes|nullable|exists:usuarios,id',
            'code' => 'sometimes|string|max:20|unique:clubs,code,' . $this->route('id'),
            'name' => 'sometimes|string|max:100',
            'direccion' => 'sometimes|nullable|string|max:100',
            'telefono' => 'sometimes|nullable|string|max:20',
            'responsable' => 'sometimes|nullable|string|max:100',
            'estado' => 'sometimes|nullable|in:Activo,Pendiente,Suspendido',
            'codigo_postal' => 'sometimes|nullable|integer',
            'localidad' => 'sometimes|nullable|string|max:255',
        ];
    }
}
