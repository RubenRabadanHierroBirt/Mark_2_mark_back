<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:150',
            'sede' => 'sometimes|nullable|string|max:100',
            'fecha' => 'sometimes|date',
            'organizador' => 'sometimes|nullable|string|max:100',
            'status' => 'sometimes|nullable|in:Borrador,Inscripcion,Cerrada,Finalizada',
            'revisado_federacion' => 'sometimes|nullable|boolean',
        ];
    }
}
