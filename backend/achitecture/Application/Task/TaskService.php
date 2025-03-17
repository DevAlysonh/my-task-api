<?php

namespace Architecture\Application\Task;

use App\Models\Task;
use Architecture\Application\Task\Dto\TaskInputDto;
use Architecture\Application\Task\Dto\TaskUpdateDto;
use Architecture\Infrastructure\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\UnauthorizedException;

class TaskService
{
    public const RESOURCES_PER_PAGE = null;

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
        if (!auth()->user()->can('update', $task)) {
            throw new UnauthorizedException('Unauthorized');
        }

        return $this->repository->update((int)$task->id, $updateData);
    }

    public function delete(Task $task): bool
    {
        if (! auth()->user()->can('delete', $task)) {
            throw new UnauthorizedException('Unauthorized');
        }

        return $this->repository->delete((int)$task->id);
    }

    public function findTasks(
        ?string $status = null,
        ?string $createdAt = null
    ): Collection|LengthAwarePaginator {
        return $this->repository->findBySubquery(SELF::RESOURCES_PER_PAGE, function ($query) use ($status, $createdAt) {
            return $query->select(
                    'id',
                    'user_id',
                    'title',
                    'description',
                    'status',
                    'created_at'
                )
                ->where('user_id', auth()->user()->id)
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($createdAt, fn ($q) => $q->where('created_at', $createdAt))
                ->with('comments');
        });
    }
}