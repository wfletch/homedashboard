<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask;
use App\Models\Tag;

class CompletedTaskController extends Controller
{
    public function getAllCompletedTasks()
    {
        $completed_tasks = CompletedTask::with('project')->orderBy('project_id')->get();
        return view('tasks._completed_task', ['completedTasks' => $completed_tasks]);
    }

    public function addCompletedTask(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'project_id' => ['required', 'integer'],
            'duration' => ['required', 'numeric'],
            'notes'      => ['nullable', 'string', 'max:5000'],
        ]);

        // Do Some minor Formatting on duration
        $validated['duration'] = round($validated['duration'], 2);
        // Insert into DB
        CompletedTask::create($validated);

        // Redirect back to dashboard
        return redirect('/');
    }
    public function updateCompletedTaskTags(Request $request, CompletedTask $completed_task)
    {
        $request->validate([
            'tag_ids' => ['array'],
            'tag_ids.*' => ['exists:tags,id'],
        ]);

        $completed_task->tags()->sync($request->tag_ids);

        return response()->noContent();
    }
}
