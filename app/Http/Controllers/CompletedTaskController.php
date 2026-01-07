<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask;
use Carbon\CarbonInterval;
use App\Models\Tag;
use App\Models\Project;

class CompletedTaskController extends Controller
{
    public function getAllCompletedTasks()
    {

        $completed_tasks = CompletedTask::with('project')
            ->get()
            ->sort(function ($a, $b) {
                // 1️⃣ Compare week DESC
                if ($a->iso_week !== $b->iso_week) {
                    return strcmp($b->iso_week, $a->iso_week);
                }

                // 2️⃣ Same week → compare day ASC
                return $a->day_of_week<=> $b->day_of_week;
            });
        $completedTasksByWeek = $completed_tasks
            ->groupBy('iso_week');
        $dailyTotalsByWeek = $completed_tasks
            ->groupBy('iso_week')
            ->map(function ($tasksInWeek) {
                return $tasksInWeek
                    ->groupBy('day_of_week')
                    ->map(function ($tasksInDay) {
                        $hours = $tasksInDay->sum('duration');

                        $interval = CarbonInterval::seconds(
                            (int) round($hours * 3600)
                        )->cascade();

                        return $interval->forHumans([
                            'short' => true,
                            'minimumUnit' => 'minute',
                        ]);
                    });
            });


        return view('tasks._completed_task', ['completedTasks' => $completed_tasks, 'dailyTotalsByWeek'    => $dailyTotalsByWeek,'completedTasksByWeek' => $completedTasksByWeek]);
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
        return redirect('/')->with('task_ended', true);
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
