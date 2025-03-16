<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTask;
use App\Http\Requests\Task\UpdateTask;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Architecture\Application\Task\Dto\TaskInputDto;
use Architecture\Application\Task\Dto\TaskUpdateDto;
use Architecture\Application\Task\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    ) {
    }

    public function index()
    {
        $tasks = $this->service->findTasks(
            request()->get('status'),
            request()->get('created_at')
        );

        $code = $tasks->empty() ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return response()->json([
            'tasks' => TaskResource::collection($tasks),
            'current_page' => $tasks->currentPage(),
            'last_page' => $tasks->lastPage(), 
        ], $code);
    }

    public function store(CreateTask $request): JsonResponse
    {
        $task = TaskInputDto::fromArray($request->validated());
        $created = $this->service->create($task);

        return response()->json(
            new TaskResource($created->refresh()),
            Response::HTTP_CREATED
        );
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json(
            new TaskResource($task),
            Response::HTTP_OK
        );
    }

    public function update(UpdateTask $request, Task $task): JsonResponse
    {
        $updateData = TaskUpdateDto::fromArray($request->validated());
        $this->service->update($task, $updateData);

        return response()->json(
            new TaskResource($task->refresh()),
            Response::HTTP_OK
        );
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->service->delete($task);

        return response()->json(
            ['message' => 'The task was deleted successfully!'],
            Response::HTTP_NO_CONTENT
        );
    }
}
