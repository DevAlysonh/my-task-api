<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->controller(TaskController::class)->group(function () {
    Route::post('tasks', 'store');
    Route::patch('tasks/{task}', 'update');
    Route::get('tasks/{task}', 'show');
    Route::get('tasks/', 'index');
    Route::delete('tasks/{task}', 'destroy');
});

Route::middleware('auth:sanctum')->controller(CommentController::class)->group(function () {
    Route::post('comments', 'store');
    Route::delete('comments/{comment}', 'destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->delete('logout', 'destroy');
});