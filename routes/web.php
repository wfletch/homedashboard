<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompletedTaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\CounterEntryController;
use App\Http\Controllers\SleepTimeController;
use App\Http\Controllers\CompletedTaskTagController;




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


//Project
Route::get('/projects', [ProjectController::class, 'listAllProjects']);
Route::put('/projects{project}', [ProjectController::class, 'updateProject']);

//Counters && CounterEntries

Route::get('/counters', [CounterController::class, 'getAllCounters']);
Route::get('/counters/{counter}/edit', [CounterController::class, 'editCounterEntriesView']);
Route::get('/counters/{counter}', [CounterController::class, 'getCounter']);
Route::post('/counters/{counter}/entries', [CounterController::class, 'addCounterEntry']);
Route::delete('/counters/{counterEntry}', [CounterController::class, 'removeCounterEntry']);

Route::patch(
    '/counters/{counterEntry}',
    [CounterController::class, 'updateCounterEntry']
);

Route::get('/sleep-times', [SleepTimeController::class, 'getAllSleepTimesGroupedByWeek']);
Route::get('/sleep-times/create', [SleepTimeController::class, 'createNewSleepTimeView']);
Route::post('/sleep-times', [SleepTimeController::class, 'createNewSleepTime']);
Route::get('/sleep-times/{sleepTime}/edit', [SleepTimeController::class, 'editSleepTimeView']);
Route::put('/sleep-times/{sleepTime}', [SleepTimeController::class, 'editSleepTime']);
Route::delete('/sleep-times/{sleepTime}', [SleepTimeController::class, 'removeSleepTimeEntry']);

# Tags
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::patch('/tags/{tag}/toggle', [TagController::class, 'toggle']);
Route::delete('/tags/{tag}', [TagController::class, 'destroy']);
# Completed Task #Tags

Route::prefix('completed-tasks/{completedTask}')->group(function () {
    Route::post('/tags', [CompletedTaskTagController::class, 'attach']);
    Route::put('/tags',  [CompletedTaskTagController::class, 'sync']);
    Route::delete('/tags/{tag}', [CompletedTaskTagController::class, 'detach']);
});
