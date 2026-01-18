<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterval;

/**
 * @property int $id
 * @property int $project_id
 * @property float $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereUpdatedAt($value)
 * @property string|null $notes
 * @property string|null $tags
 * @property-read string $iso_week
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereTags($value)
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereStartedAt($value)
 * @property-read int|null $tags_count
 * @property-read string $duration_human
 * @property string|null $title
 * @property-read string $day_of_year
 * @property-read \App\Models\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompletedTask whereTitle($value)
 * @mixin \Eloquent
 */
class CompletedTask extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'duration',
        'notes',
        'tags',
        'started_at',
        'created_at',
        'ended_at',
    ];

    protected $casts = [
        'duration'   => 'decimal:2',
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'created_at'   => 'datetime',
    ];

    public function tags()  {
        return $this->belongsToMany(Tag::class)
                    ->where('enabled', true);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    protected $appends = ['iso_week' , 'duration_human', 'day_of_year', 'day_of_week', 'day_of_week_name', 'human_day'];

    public function getDayOfYearAttribute(): string
    {
        return sprintf('%03d', $this->created_at->dayOfYear);
    }
    public function getIsoWeekAttribute(): string
    {
        return sprintf(
            '%d-W%02d',
            $this->created_at->weekOfYear(),
            $this->created_at->isoWeek
        );
    }
    public function getDayOfWeekNameAttribute(): string
    {
        return strtolower($this->created_at->dayName ?? '');
    }
    public function getHumanDayAttribute(): string
    {
        return $this->created_at->format('l jS F');
    }
    public function getDayOfWeekAttribute(): int
    {
        return $this->created_at->isoWeekday();
        // return $this->created_at?->isoWeekday ?? 0;
    }

    public function getDurationHumanAttribute(): string
    {
        $hours = $this->duration; // decimal hours like 0.75

        $interval = CarbonInterval::seconds(
                (int) round($hours * 3600)
            )->cascade();

        return $interval->forHumans([
            'short' => true,
            'minimumUnit' => 'minute',
        ]);
    }
}
