<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'sede' => 'nullable|string|max:100',
            'fecha' => 'required|date',
            'organizador' => 'nullable|string|max:100',
            'status' => 'nullable|in:Borrador,Inscripcion,Cerrada,Finalizada',
            'revisado_federacion' => 'nullable|boolean',
        ];
    }
}
