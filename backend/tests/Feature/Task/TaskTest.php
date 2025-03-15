<?php

namespace Tests\Feature\Task;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    public function testIfUsersCanCreateANewTask(): void
    {
        $arr = [
            'title' => 'Foo Bar',
            'status' => 'pending',
        ];

        $response = $this->post('/api/tasks', $arr);

        $response->assertStatus(204);
    }
}
