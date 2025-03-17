<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
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
        $response->assertStatus(Response::HTTP_CREATED);

        $data = $response->getData();
        $this->assertEquals($data->user_name, $this->user->name);
        $this->assertEquals($data->task_id, $this->task->id);
        $this->assertEquals($data->content, $arr['content']);
    }

    public function test_UserShouldCanDeleteAComment(): void
    {
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->delete("/api/comments/{$comment->id}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_UserCannotDeleteACommentFromAnotherUser(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');

        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id
        ]);

        $this->actingAs(User::factory()->createOne())
            ->delete("/api/comments/{$comment->id}");
    }
}
