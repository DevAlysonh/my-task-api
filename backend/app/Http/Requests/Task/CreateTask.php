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
            'title' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Este campo é obrigatório'
        ];
    }
}
