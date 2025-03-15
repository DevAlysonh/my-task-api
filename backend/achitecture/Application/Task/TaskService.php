<?php

namespace Architecture\Application\Task;

use App\Models\Task\Task;
use Architecture\Application\Task\Dto\TaskInputDto;
use Illuminate\Cache\Repository;

class TaskService
{
    public function __construct(protected Repository $repository)
    { }

    public function create(TaskInputDto $task): Task
    {
        return Task::create($task->toArray());       
    }
}