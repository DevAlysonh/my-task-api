<?php

namespace Architecture\Application\Task\Dto;

use DtoInterface;
use Exception;

class TaskInputDto implements DtoInterface
{
    public function __construct(protected string $title)
    { }

    public static function fromArray(array $data): self
    {
        if(empty($data['title'])) {
            throw new Exception('You should give a title for a new Task!');
        }

        return new self($data['title']);
    }

    public function toArray(): array
    {
        return ['title' => $this->title];
    }
}