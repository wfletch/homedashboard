<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
