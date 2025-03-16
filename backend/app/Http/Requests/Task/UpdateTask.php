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
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:pending,completed,progress,cancelled']
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'O título não deve conter mais de 100 caracteres',
            'description.max' => 'A descrição não deve conter mais de 500 caracteres',
            '*.string' => 'Este campo deve conter um texto',
            'status.in' => 'Status inválido, os status permitidos são: Pendente, Completo, Em progresso ou Cancelado.',
            '*.required' => 'Campo obrigatório'
        ];
    }
}
