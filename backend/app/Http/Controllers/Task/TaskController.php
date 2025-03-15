<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTask;
use App\Http\Resources\Task\TaskResource;
use Architecture\Application\Task\Dto\TaskInputDto;
use Architecture\Application\Task\TaskService;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    { }

    public function store(CreateTask $request)
    {
        $task = TaskInputDto::fromArray($request->validated());
        $created = $this->service->create($task);

        return response()->json(
            new TaskResource($created->refresh()),
            Response::HTTP_CREATED
        );
    }
}
