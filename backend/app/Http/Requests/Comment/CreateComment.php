<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateComment extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:500'],
            'task_id' => ['required', 'int']
        ];
    }

    public function messages()
    {
        return [
            '*.required' => "Este campo é obrigatório"
        ];
    }
}
