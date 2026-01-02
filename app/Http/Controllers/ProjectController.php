<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function listAllProjects()
    {
        return Project::all();
    }

    public function createNewProject(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'enabled'  => ['boolean'],
        ]);

        return Project::create($validated);
    }

    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'enabled'  => ['boolean'],
        ]);

        $project->update($validated);

        return $project;
    }
}
