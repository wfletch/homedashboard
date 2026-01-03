<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Counter;
class CounterSeeder extends Seeder
{
    public function run(): void
    {
        Counter::firstOrCreate([
            'name' => "Watch 100 Youtube Videos That I Disagree With",
            'goal' => 100,
        ]);
        Counter::firstOrCreate([
            'name' => "Watch 100 Guitarists",
            'goal' => 100,
        ]);
        Counter::firstOrCreate([
            'name' => "Gym 100 Sessions",
            'goal' => 100,
        ]);
        Counter::firstOrCreate([
            'name' => "Hike 10 Trails",
            'goal' => 10,
        ]);
        Counter::firstOrCreate([
            'name' => "Create 52 Sketches",
            'goal' => 52,
        ]);
        Counter::firstOrCreate([
            'name' => "Learn 52 Standards",
            'goal' => 52,
        ]);
    }
}
