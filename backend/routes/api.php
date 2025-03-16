<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(TaskController::class)->group(function () {
    Route::post('tasks', 'store');
    Route::patch('tasks/{task}', 'update');
    Route::get('tasks/{task}', 'show');
    Route::delete('tasks/{task}', 'destroy');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('comments', 'store');
    Route::delete('comments/{comment}', 'destroy');
});