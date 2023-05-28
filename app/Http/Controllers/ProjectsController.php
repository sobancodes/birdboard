<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        $project = $user->projects()->create($this->validateRequest($request));

        return redirect($project->path());
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest($request));
        
        return redirect($project->path());
    }

    protected function validateRequest($request)
    {
        return $request->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'max:255',
        ]);
    }
}
