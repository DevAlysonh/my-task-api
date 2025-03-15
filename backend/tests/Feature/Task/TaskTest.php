<?php

namespace Tests\Feature\Task;

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
        $this->assertEquals($response->getData()->message, 'New Task created Successfully');
    }
}
