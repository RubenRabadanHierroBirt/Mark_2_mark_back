<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResultsRequest extends FormRequest
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
            'tipo_evento' => 'sometimes|string|max:50',
            'categoria' => 'sometimes|nullable|string|max:20',
            'marca' => 'sometimes|nullable|string|max:20',
            'posicion' => 'sometimes|nullable|integer|min:1',
            'wind_speed' => 'sometimes|nullable|numeric|between:-9.9,9.9'
        ];
    }
}
