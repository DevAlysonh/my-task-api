<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->task = Task::factory()->create();
        $this->user = User::first();
    }

    public function test_UserShouldCanCreateANewComment(): void
    {
        $arr = [
            'content' => 'Foo bar',
            'task_id' => $this->task->id
        ];
        $response = $this->actingAs($this->user)->post('/api/comments', $arr);
        $data = $response->getData()->data;
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals($data->user_id, $this->user->id);
        $this->assertEquals($data->task_id, $this->task->id);
        $this->assertEquals($data->content, $arr['content']);
    }
}
