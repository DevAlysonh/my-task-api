<?php

namespace Architecture\Domain\Task\ValueObjects;

use InvalidArgumentException;

class Title
{
    protected string $value;

    public function __construct(
        protected string $title
    ) {
        $this->validateTitle($title);
        $this->value = $title;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validateTitle(string $title)
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException("O título da tarefa não pode estar vazio.");
        }

        if (strlen($title) > 100) {
            throw new InvalidArgumentException("O título da tarefa não pode ter mais de 100 caracteres.");
        }
    }
}