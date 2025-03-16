<?php

namespace Architecture\Application\Comment\Dto;

use App\Models\User;
use Architecture\Application\Common\Interfaces\DtoInterface;
use Architecture\Domain\Comment\ValueObjects\Content;
use Architecture\Domain\Task\ValueObjects\TaskId;

class CommentInputDto implements DtoInterface
{
    public function __construct(
        protected Content $content,
        protected TaskId $taskId,
        protected User $user
    ) {        
    }

    public static function fromArray(array $data): self
    {
        $content = new Content($data['content']);
        $taskId = new TaskId($data['task_id']);
        $user = auth()->user();

        return new self($content, $taskId, $user);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'content' => $this->content->value(),
            'task_id' => $this->taskId->value()
        ];
    }
}