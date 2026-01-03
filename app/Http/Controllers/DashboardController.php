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

        $completedTasks = CompletedTask::with('project')
            ->orderBy('iso_week')
            ->orderBy('project_id')
            ->get();

        $completedTasksByWeek = $completedTasks
            ->groupBy('iso_week')
            ->sortKeysDesc();
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
            'completedTasksByWeek' => $completedTasksByWeek,
            'runningTask' => $runningTask,
            'projects' => $projects,
            'tags' => $tags,
            'counters' => $counters,
        ]);
    }



}
