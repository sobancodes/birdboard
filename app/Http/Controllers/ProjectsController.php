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

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->projects()->create($attributes);

        return redirect('/projects');
    }

    public function show(Project $project)
    {
        /** @var User::class */
        $user = auth()->user();
        if ($user->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }
}
