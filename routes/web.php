<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::post('/dashboard/project-duration', [DashboardController::class, 'store']);
Route::post('/dashboard/start-task', [DashboardController::class, 'startTask']);
Route::post('/dashboard/end-task', [DashboardController::class, 'endTask']);
