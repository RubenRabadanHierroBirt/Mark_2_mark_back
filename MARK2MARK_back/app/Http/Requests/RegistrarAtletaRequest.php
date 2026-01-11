<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAtletaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_competicion' => 'required|integer|exists:competiciones,id',
            'id_atleta' => 'required|integer|exists:atletas,id',
            'tipo_evento' => 'required|string',
        ];
    }
}
