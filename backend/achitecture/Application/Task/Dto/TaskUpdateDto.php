<?php

namespace Architecture\Application\Task\Dto;

use Architecture\Application\Common\Interfaces\DtoInterface;
use Architecture\Application\Task\TaskStatus;
use Architecture\Domain\Task\ValueObjects\Description;
use Architecture\Domain\Task\ValueObjects\Title;

class TaskUpdateDto implements DtoInterface
{
    public function __construct(
        protected Title $title,
        protected Description $description,
        protected TaskStatus $status
    ) {  
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new Title($data['title']),
            new Description($data['description']),
            TaskStatus::from($data['status'])
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title->value(),
            'description' => $this->description->value(),
            'status' => $this->status->value
        ];
    }
}