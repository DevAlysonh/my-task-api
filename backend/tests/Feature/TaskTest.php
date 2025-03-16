<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Architecture\Application\Task\TaskStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    protected Task $task;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->task = Task::factory()->createOne();
        $this->user = User::factory()->createOne();
    }

    public function test_UsersShouldCanCreateANewTask(): void
    {
        $arr = [
            'title' => 'Foo Bar',
            'description' => 'Do something on this task as soon as a possible!'
        ];

        $response = $this->actingAs($this->user)->post('/api/tasks', $arr);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->data->title, $arr['title']);
        $this->assertEquals($response->getData()->data->description, $arr['description']);
        $this->assertEquals($response->getData()->data->status, TaskStatus::PENDING->value);
    }

    public function test_UsersShouldCanUpdateATask(): void
    {
        $arr = [
            'title' => 'Foo Bar Edited',
            'description' => 'Another description now!',
            'status' => 'completed'
        ];

        $response = $this->patch("/api/tasks/{$this->task->id}", $arr);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->data->title, $arr['title']);
        $this->assertEquals($response->getData()->data->description, $arr['description']);
        $this->assertEquals($response->getData()->data->status, TaskStatus::COMPLETED->value);
    }

    public function test_UsersCanGetASpecifcTask(): void
    {
        $response = $this->get("/api/tasks/{$this->task->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_UsersCanDeleteATask(): void
    {
        $response = $this->delete("/api/tasks/{$this->task->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
