<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message' => 'New Task created Successfully',
            'data' => [
                'title' => $this->title,
                'status' => $this->status,
                'created_at' => $this->created_at,
            ],
        ];
    }
}
