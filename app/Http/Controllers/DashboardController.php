<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\ProjectDuration;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        // Load ALL rows
        $durations = ProjectDuration::all();
        $runningTask = Task::whereNull('stopped_at')->latest('started_at')->first();
        return view('dashboard_home', [
            'durations' => $durations,
            'runningTask' => $runningTask,
        ]);
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'project_id' => ['required', 'integer'],
            'duration' => ['required', 'numeric'],
            'notes'      => ['nullable', 'string', 'max:5000'],
        ]);

        // Insert into DB
        ProjectDuration::create($validated);

        // Redirect back to dashboard
        return redirect('/');
    }

    public function startTask(Request $request)
    {
        $validated = $request->validate([
        'project_id' => ['required', 'integer'],
        'notes'      => ['nullable', 'string', 'max:5000'],
    ]);

    Task::create([
        'project_id' => $validated['project_id'],
        'notes'      => $validated['notes'] ?? null,
        'started_at' => now(),
    ]);

        return redirect('/');
    }

    public function endTask()
    {
        DB::transaction(function () {

            // 1️⃣ Find the running task
            $task = Task::whereNull('stopped_at')
                ->orderBy('started_at', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            if (!$task) {
                return;
            }

            // 2️⃣ Stop the task
            $endedAt = now();
            $task->stopped_at = $endedAt;
            $task->save();

            // 3️⃣ Compute duration in hours (float)
            $durationHours = $task->started_at->diffInSeconds($endedAt) / 3600;

            // 4️⃣ Create duration entry
            ProjectDuration::create([
                'project_id' => $task->project_id,
                'notes'      => $task->notes,
                'started_at' => $task->started_at,
                'ended_at'   => $endedAt,
                'duration'   => $durationHours,
            ]);
        });

        return redirect('/');
    }

}
