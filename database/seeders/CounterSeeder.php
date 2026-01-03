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
    }
}
