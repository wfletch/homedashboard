<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function getCurrentTask(Request $request)
    {
        // Load ALL rows
        $runningTask = Task::with('project')->whereNull('stopped_at')
                                            ->latest('started_at')
                                            ->first();
        if ($request->hasHeader('wfletch-home-dashboard')) {
            return response()->json($runningTask, 200);
        } else {
            return view('tasks._current_task', ['runningTask' => $runningTask]);
        }
    }
    public function startTask(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'integer'],
            'notes'      => ['nullable', 'string', 'max:5000'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        Task::create([
            'project_id' => $validated['project_id'],
            'notes'      => $validated['notes'] ?? null,
            'title'      => $validated['title'] ?? null,
            'started_at' => now(),
        ]);
        return redirect('/');
    }

    public function endTask(Request $request)
    {
        $completed_task = array();
        DB::transaction(function () use ($request, &$completed_task){

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

            if (!$request->hasHeader('wfletch-test')) {
                $task->stopped_at = $endedAt;
            }
            $task->save();

            // 3️⃣ Compute duration in hours (float)
            $durationHours = round($task->started_at->diffInSeconds($endedAt) / 3600
                ,2
            );

            // 4️⃣ Create duration entry
            if ($request->hasHeader('wfletch-test')) {
                $completed_task = [
                    'project_id' => $task->project_id,
                    'notes'      => $task->notes,
                    'started_at' => $task->started_at,
                    'title' => $task->title,
                    'ended_at'   => $endedAt,
                    'duration'   => $durationHours,
                ];
            } else {
                $completed_task = CompletedTask::create([
                    'project_id' => $task->project_id,
                    'notes'      => $task->notes,
                    'started_at' => $task->started_at,
                    'title' => $task->title,
                    'ended_at'   => $endedAt,
                    'duration'   => $durationHours,
                ]);

                $task->delete();
            }
        });

        if ($request->hasHeader('wfletch-home-dashboard')) {
            if (empty($completed_task)) {
                return response()->json($completed_task, 418);
            }
            else {
                return response()->json($completed_task, 200);
            }
            return redirect('/')->with('task_ended', true);
        }
    }
}
