<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompletedTaskController;
use App\Http\Controllers\TagController;



// General
Route::get('/', [DashboardController::class, 'index']);

Route::post('/tasks/start-task', [TaskController::class, 'startTask']);
Route::post('/tasks/end-task', [TaskController::class, 'endTask']);

//Task
Route::get('/tasks/current-task', [TaskController::class, 'getCurrentTask']);

//Completed Task
Route::get('/completed-tasks', [CompletedTaskController::class, 'getAllCompletedTasks']);
Route::get('/completed-tasks/{completed_task}/edit',[CompletedTaskController::class, 'editCompletedTaskView']);
Route::put('/completed-tasks/{completed_task}', [CompletedTaskController::class, 'updateCompletedTask']);
Route::post('/completed-tasks/add-completed-task', [CompletedTaskController::class, 'addCompletedTask']);

Route::delete('/completed-tasks/{completedTask}',[CompletedTaskController::class, 'destroyCompletedTask']);

//Tag
Route::get('/tags', [TagController::class, 'getAllTags']);
Route::put('/tags/{tag}', [TagController::class, 'updateTag']);

//Project
Route::get('/projects', [ProjectController::class, 'listAllProjects']);
Route::put('/projects{project}', [ProjectController::class, 'updateProject']);
