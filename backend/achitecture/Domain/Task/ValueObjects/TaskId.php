<?php

namespace Architecture\Domain\Task\ValueObjects;

use InvalidArgumentException;

class TaskId
{
    protected int $value;

    public function __construct(protected int $taskId)
    {
        $this->validateTaskId($taskId);
        $this->value = $taskId;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function validateTaskId(int $taskId)
    {
        if($taskId <= 0) {
            throw new InvalidArgumentException('O ID da tarefa deve ser um número positivo.');
        }
    }
}