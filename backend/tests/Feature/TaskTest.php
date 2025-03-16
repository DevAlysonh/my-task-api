<?php

namespace Tests\Feature;

use App\Models\Task;
use Architecture\Application\Task\TaskStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    public function test_UsersShouldCanCreateANewTask(): void
    {
        $arr = [
            'title' => 'Foo Bar',
        ];

        $response = $this->post('/api/tasks', $arr);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->data->title, $arr['title']);
        $this->assertEquals($response->getData()->data->status, TaskStatus::PENDING->value);
    }

    public function test_UsersShouldCanUpdateATask(): void
    {
        $task = Task::factory()->createOne();

        $arr = [
            'title' => 'Foo Bar Edited',
            'status' => 'completed'
        ];

        $response = $this->patch("/api/tasks/{$task->id}", $arr);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->data->title, $arr['title']);
        $this->assertEquals($response->getData()->data->status, TaskStatus::COMPLETED->value);
    }

    public function test_UsersCanGetASpecifcTask(): void
    {
        $task = Task::factory()->createOne();

        $response = $this->get("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_OK);
    }
}
