<?php

namespace Architecture\Application\Task\Dto;

use Exception;

class TaskUpdateDto implements DtoInterface
{
    public function __construct(
        protected string $title,
        protected string $status
    ) {  
    }

    public static function fromArray(array $data): self
    {
        $data = array_filter($data);

        if (empty($data)) {
            throw new Exception('An empty array of data was given to update a task');
        }

        return new self($data['title'], $data['status']);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'status' => $this->status
        ];
    }
}