<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SleepTime;
use Illuminate\Support\Carbon;

class SleepTimeSeeder extends Seeder
{
    public function run(): void
    {
        $yesterday = Carbon::yesterday()->toDateString();
        $today = Carbon::today()->toDateString();

        SleepTime::firstOrCreate(
            ['day' => $yesterday],
            [
                'bed_time' => '23:59',
                'wake_time' => '00:00',
            ]
        );

        SleepTime::firstOrCreate(
            ['day' => $today],
            [
                'bed_time' => '00:00',
                'wake_time' => '12:30',
            ]
        );
    }
}
