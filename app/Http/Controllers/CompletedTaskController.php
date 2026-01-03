<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask;
use App\Models\Tag;
use App\Models\Project;

class CompletedTaskController extends Controller
{
    public function getAllCompletedTasks()
    {
        $completed_tasks = CompletedTask::with('project')
            ->orderBy('day_of_week')
            ->get();

        $completedTasksByWeek = $completed_tasks
            ->groupBy('iso_week')
            ->sortKeysDesc();


        return view('tasks._completed_task', ['completedTasks' => $completed_tasks, 'completedTasksByWeek' => $completedTasksByWeek]);
    }

    public function addCompletedTask(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'project_id' => ['required', 'integer'],
            'duration' => ['required', 'numeric'],
            'notes'      => ['nullable', 'string', 'max:5000'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        // Do Some minor Formatting on duration
        $validated['duration'] = round($validated['duration'], 2);
        // Insert into DB
        CompletedTask::create($validated);

        // Redirect back to dashboard
        return redirect('/');
    }

    public function editCompletedTaskView(CompletedTask $completedTask)
    {
        $projects = Project::where('enabled', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('tasks._edit_completed_task', compact(
            'completedTask',
            'projects'
        ));
    }
    public function updateCompletedTask(Request $request, CompletedTask $completedTask)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'duration'   => ['required', 'numeric'],
            'notes'      => ['nullable', 'string'],
            'title'      => ['nullable', 'string'],
        ]);

        $completedTask->update($validated);

        return response()->noContent();
    }
    public function destroyCompletedTask(CompletedTask $completedTask)
    {
        $completedTask->delete();

        return redirect('/');
    }
}
