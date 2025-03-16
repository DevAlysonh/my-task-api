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
            'task_id' => ['required', 'int', 'exists:tasks,id']
        ];
    }

    public function messages()
    {
        return [
            '*.required' => "Este campo é obrigatório",
            'task.exists' => "A tarefa que você está tentando comentar não existe ou foi excluida."
        ];
    }
}
