<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Architecture\Application\Task\TaskStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    protected Task $task;
    protected User $user;
    protected User $wrongUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
        $this->task = Task::factory()->create(['user_id' => $this->user->id]);
        $this->wrongUser = User::factory()->createOne();
    }

    public function test_UsersShouldCanCreateANewTask(): void
    {
        $arr = [
            'title' => 'Foo Bar',
            'description' => 'Do something on this task as soon as a possible!'
        ];

        $response = $this->actingAs($this->user)
            ->post('/api/tasks', $arr);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->title, $arr['title']);
        $this->assertEquals($response->getData()->description, $arr['description']);
        $this->assertEquals($response->getData()->status, TaskStatus::PENDING->value);
    }

    public function test_UsersShouldCanUpdateATask(): void
    {
        $arr = [
            'title' => 'Foo Bar Edited',
            'description' => 'Another description now!',
            'status' => 'completed'
        ];

        $response = $this->actingAs($this->user)
            ->patch("/api/tasks/{$this->task->id}", $arr);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($response->getData()->title, $arr['title']);
        $this->assertEquals($response->getData()->description, $arr['description']);
        $this->assertEquals($response->getData()->status, TaskStatus::COMPLETED->value);
    }

    public function test_UsersCannotUpdateATaskFromAnotherUser(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $arr = [
            'title' => 'Foo Bar Edited',
            'description' => 'Another description now!',
            'status' => 'completed'
        ];

        $this->actingAs($this->wrongUser)
            ->patch("/api/tasks/{$this->task->id}", $arr);
    }

    public function test_UsersCanGetASpecifcTask(): void
    {
        $response = $this->actingAs($this->user)
            ->get("/api/tasks/{$this->task->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_UsersCanDeleteATask(): void
    {
        $response = $this->actingAs($this->user)
            ->delete("/api/tasks/{$this->task->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_UsersCannotDeleteATaskFromAnotherUser(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');

        $response = $this->actingAs($this->wrongUser)
            ->delete("/api/tasks/{$this->task->id}");
    }
}
