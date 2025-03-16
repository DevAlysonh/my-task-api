<?php

namespace Architecture\Application\Task;

use App\Models\Task;
use Architecture\Application\Task\Dto\TaskInputDto;
use Architecture\Application\Task\Dto\TaskUpdateDto;
use Architecture\Infrastructure\Repository\Repository;

class TaskService
{
    public function __construct(protected Repository $repository)
    { 
        $this->repository->setCollectionName('task');
    }

    public function create(TaskInputDto $task): Task
    {
        return $this->repository->create($task);       
    }

    public function update(Task $task, TaskUpdateDto $updateData): bool
    {
        return $this->repository->update($task, $updateData);
    }

    public function delete(Task $task): bool
    {
        return $this->repository->delete($task->id);
    }
}