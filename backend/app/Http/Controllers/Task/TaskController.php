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
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    { }

    public function store(CreateTask $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $task = TaskInputDto::fromArray($data);
        $created = $this->service->create($task);

        return response()->json(
            new TaskResource($created->refresh()),
            Response::HTTP_CREATED
        );
    }

    public function show(Task $task)
    {
        return response()->json(
            new TaskResource($task),
            Response::HTTP_OK
        );
    }

    public function update(UpdateTask $request, Task $task)
    {
        $updateData = TaskUpdateDto::fromArray($request->validated());
        $this->service->update($task, $updateData);

        return response()->json(
            new TaskResource($task->refresh()),
            Response::HTTP_OK
        );
    }

    public function destroy(Task $task)
    {
        $this->service->delete($task);

        return response()->json(
            ['message' => 'The task was deleted successfully!'],
            Response::HTTP_NO_CONTENT
        );
    }
}
