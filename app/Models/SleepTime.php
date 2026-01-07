<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $day
 * @property string $bed_time
 * @property string $wake_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read float|null $sleep_hours
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereBedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SleepTime whereWakeTime($value)
 * @mixin \Eloquent
 */
class SleepTime extends Model
{
    protected $fillable = [
        'day',
        'bed_time',
        'wake_time',
    ];

    protected $casts = [
        'day' => 'date',
    ];

    protected $appends = ['sleep_hours'];

    public function getSleepHoursAttribute(): ?float
    {
        // Find previous record by day
        $previous = self::where('id', '<', $this->day)
            ->orderByDesc('id')
            ->first();

        if (! $previous) {
            return null;
        }

        $bed = Carbon::parse(
            $previous->day->toDateString() . ' ' . $previous->bed_time
        );

        $wake = Carbon::parse(
            $this->day->toDateString() . ' ' . $this->wake_time
        );

        // Handle sleeping past midnight
        if ($wake->lessThan($bed)) {
            $wake->addDay();
        }

        return round($bed->diffInMinutes($wake) / 60, 2);
    }
}
