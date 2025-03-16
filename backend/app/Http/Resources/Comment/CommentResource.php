<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'user_id' => $this->user_id,
                'content' => $this->content,
                'task_id' => $this->task_id,
                'created_at' => $this->created_at
            ]
        ];
    }
}
