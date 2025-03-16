<?php

use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(TaskController::class)->group(function () {
    Route::post('tasks', 'store');
    Route::patch('tasks/{task}', 'update');
});
