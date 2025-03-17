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
use Illuminate\Pagination\LengthAwarePaginator;

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

        $pagination = [
            'current_page' => null,
            'last_page' => null,
        ];

        if ($tasks instanceof LengthAwarePaginator) {
            $pagination['current_page'] = $tasks->currentPage();
            $pagination['last_page'] = $tasks->lastPage();
        }

        $code = $tasks->count() ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        return response()->json(array_merge(
                ['tasks' => TaskResource::collection($tasks)],
                $pagination
            )
        , $code);
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
            new TaskResource($task->load('comments')),
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
