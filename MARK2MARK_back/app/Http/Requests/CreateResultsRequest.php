<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResultsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_competicion' => 'required|exists:competiciones,id',
            'id_atleta' => 'required|exists:atletas,id',
            'tipo_evento' => 'required|string|max:50',
            'categoria' => 'nullable|string|max:20',
            'marca' => 'nullable|string|max:20',
            'posicion' => 'nullable|integer|min:1',
            'wind_speed' => 'nullable|numeric|between:-9.9,9.9',
        ];
    }
}
