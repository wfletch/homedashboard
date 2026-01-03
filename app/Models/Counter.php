<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int|null $goal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $enabled
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CounterEntry> $entries
 * @property-read int|null $entries_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Counter extends Model
{
    protected $fillable = ['name', 'goal', 'enabled'];
    public function entries()
    {
        return $this->hasMany(CounterEntry::class);
    }
}
