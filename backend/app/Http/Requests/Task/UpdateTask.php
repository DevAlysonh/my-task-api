<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTask extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'status' => ['required', 'string', 'in:pending,completed,progress,cancelled']
        ];
    }

    public function messages()
    {
        return [
            '*.string' => 'Este campo deve conter um texto',
            'status.in' => 'Status inválido, os status permitidos são: Pendente, Completo, Em progresso ou Cancelado.'
        ];
    }
}
