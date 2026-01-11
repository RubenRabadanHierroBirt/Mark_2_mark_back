<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'fecha' => 'sometimes|nullable|date',
            'contenido' => 'sometimes|string',
            'tipo' => 'sometimes|in:info,alerta,resultado,competicion',
        ];
    }
}
