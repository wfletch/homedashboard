<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::firstOrCreate([
            'name'     => 'Music Weekly',
            'category' => 'music',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Music Jazz',
            'category' => 'music',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Nvim Configuration',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Music Song',
            'category' => 'music',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Visualizer',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Open Source',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Home Dashboard',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'RT Programming',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'RT Non Programming',
            'category' => 'development',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'HYENA Programming',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'HYENA Non Programming',
            'category' => 'development',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Game Engine',
            'category' => 'programming',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'EP',
            'category' => 'music',
            'enabled'  => true,
        ]);

        Project::firstOrCreate([
            'name'     => 'Test',
            'category' => 'test',
            'enabled'  => true,
        ]);
    }
}
