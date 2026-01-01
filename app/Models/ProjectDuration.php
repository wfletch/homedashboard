<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property float $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereUpdatedAt($value)
 * @property string|null $notes
 * @property string|null $tags
 * @property-read string $iso_week
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDuration whereTags($value)
 * @mixin \Eloquent
 */
class ProjectDuration extends Model
{
    protected $fillable = [
        'project_id',
        'duration',
        'notes',
        'tags',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    protected $appends = ['iso_week'];

        public function getIsoWeekAttribute(): string
        {
            return $this->created_at->format('o-\WW');
        }
}
