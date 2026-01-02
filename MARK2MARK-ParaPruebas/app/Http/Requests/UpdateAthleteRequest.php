<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAthleteRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:100',
            'email' => 'sometimes|nullable|email|max:100',
            'telefono' => 'sometimes|nullable|string|max:20',
            'fecha_nacimiento' => 'sometimes|nullable|date',
            'status' => 'sometimes|nullable|in:Activo,Pendiente,Suspendido',
            'sexo' => 'sometimes|nullable|in:M,F',
            'club_actual_id' => 'sometimes|nullable|exists:clubs,id',
        ];
    }
}
