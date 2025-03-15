<?php

namespace Architecture\Application\Task;

use App\Models\Task;
use Architecture\Application\Task\Dto\TaskInputDto;
use Architecture\Infrastructure\Repository\Repository;

class TaskService
{
    public function __construct(protected Repository $repository)
    { }

    public function create(TaskInputDto $task): Task
    {
        $this->repository->setCollectionName('task');
        return $this->repository->create($task);       
    }
}