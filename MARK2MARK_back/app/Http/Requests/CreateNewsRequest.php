<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha' => 'nullable|date',
            'contenido' => 'required|string',
            'tipo' => 'required|in:info,alerta,resultado,competicion',
        ];
    }
}
