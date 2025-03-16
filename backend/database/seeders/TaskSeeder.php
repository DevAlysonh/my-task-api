<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Task::factory(10)
            ->has(
                Comment::factory(3)
                    ->state(['user_id' => $user->id])
            )
            ->create(['user_id' => $user->id]);
    }
}
