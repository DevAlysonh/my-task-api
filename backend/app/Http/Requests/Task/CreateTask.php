<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'max:500']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Este campo é obrigatório',
            'title.max' => 'O título não deve conter mais de 100 caracteres',
            'description.max' => 'A descrição não deve conter mais de 500 caracteres'
        ];
    }
}
