<?php

namespace Architecture\Application\Task\Dto;

use Exception;

class TaskInputDto
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

    public function toArray()
    {
        return ['title' => $this->title];
    }
}