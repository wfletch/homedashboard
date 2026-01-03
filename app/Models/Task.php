<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterval;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $stopped_at
 * @property int $project_id
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStoppedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @property-read float $current_duration
 * @property-read string $current_duration_human
 * @property-read string $iso_week
 * @property string|null $title
 * @property-read string $day_of_year
 * @property-read \App\Models\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTitle($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    protected $fillable = [
        'started_at',
        'stopped_at',
        'project_id',
        'title',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    protected $appends = ['iso_week', 'day_of_year', 'current_duration', 'current_duration_human'];

    public function getDayOfYearAttribute(): string
    {
        return sprintf('%03d', $this->created_at->dayOfYear);
    }
    public function getIsoWeekAttribute(): string
    {
        return $this->created_at->format('o-\WW');
    }

    public function getCurrentDurationAttribute(): float
    {
        return round($this->created_at
                          ->diffInMinutes(now()) / 60,
                      2
        );
    }

    public function getCurrentDurationHumanAttribute(): string
    {
        $seconds = $this->created_at->diffInSeconds(now());

        $interval = CarbonInterval::seconds($seconds)->cascade();
        return $interval->forHumans([
            'short' => true,'minimumUnit' => 'seconds',
        ]);
    }

}
