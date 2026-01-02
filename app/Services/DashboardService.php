<?php
namespace App\Services;

use App\Models\CompletedTask;

class DashboardService
{
    public function getCompletedTasks()
    {
        return CompletedTask::all()
            ->groupBy('project_id')
            ->map(fn ($group) => [
                'project_id' => $group->first()->project_id,
                'total_duration' => $group->sum('duration'),
            ])
            ->values();
    }
}
