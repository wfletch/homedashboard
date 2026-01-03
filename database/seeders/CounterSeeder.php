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
        Counter::firstOrCreate([
            'name' => "Read 12 Books",
            'goal' => 12,
        ]);
        Counter::firstOrCreate([
            'name' => "Play 10 Indie Games",
            'goal' => 10,
        ]);
        Counter::firstOrCreate([
            'name' => "Have Sex 100 Times",
            'goal' => 100,
        ]);
        Counter::firstOrCreate([
            'name' => "Vist 5 Museums",
            'goal' => 5,
        ]);
        Counter::firstOrCreate([
            'name' => "Make 5 New Friends",
            'goal' => 5,
        ]);
        Counter::firstOrCreate([
            'name' => "Watch 5 Live Shows",
            'goal' => 5,
        ]);
        Counter::firstOrCreate([
            'name' => "Listen to 52 OSTs",
            'goal' => 52,
        ]);
        Counter::firstOrCreate([
            'name' => "Learn 10 'Normal' Songs",
            'goal' => 10,
        ]);
    }
}
