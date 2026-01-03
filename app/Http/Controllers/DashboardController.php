<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\CompletedTask;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Project;
use App\Models\Counter;

class DashboardController extends Controller
{
    public function index()
    {
        // Load ALL rows
        $completedTasks= CompletedTask::all();

        $counters= Counter::where('enabled', true)
            ->orderBy('id')
            ->get();
        $tags = Tag::where('enabled', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        $projects = Project::where('enabled', true)
            ->orderBy('category')
            ->get(['id', 'name', 'category']);
        $runningTask = Task::whereNull('stopped_at')
            ->latest('started_at')
            ->first();
        return view('dashboard_home', [
            'completedTasks' => $completedTasks,
            'runningTask' => $runningTask,
            'projects' => $projects,
            'tags' => $tags,
            'counters' => $counters,
        ]);
    }



}
