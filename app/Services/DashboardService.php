<?php
namespace App\Services;

use App\Models\ProjectDuration;

class DashboardService
{
    public function getProjectDurations()
    {
        return ProjectDuration::all()
            ->groupBy('project_id')
            ->map(fn ($group) => [
                'project_id' => $group->first()->project_id,
                'total_duration' => $group->sum('duration'),
            ])
            ->values();
    }
}
