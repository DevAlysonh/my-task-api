<?php

namespace Architecture\Domain\Task\ValueObjects;

use InvalidArgumentException;

class Description
{
    protected string $value;

    public function __construct(
        protected string $description = ''
    ) {
        $this->validateDescription($description);
        $this->value = $description;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validateDescription(string $description)
    {
        if (strlen($description) > 500) {
            throw new InvalidArgumentException('A descrição da tarefa não pode ter mais de 500 caracteres!');
        }
    }
}