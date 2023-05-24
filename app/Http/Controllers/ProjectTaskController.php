<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        /** @var App\Models\User */
        $user = auth()->user();

        if ($user->isNot($project->owner)) {
            abort(403);
        }

        $request->validate(['body' => 'required']);

        $project->addTask($request->body);

        return redirect($project->path());
    }

    public function update(Request $request, Project $project, Task $task)
    {
        /** @var App\Models\User */
        $user = auth()->user();

        if ($user->isNot($project->owner)) {
            abort(403);
        }

        $request->validate(['body' => 'required']);
        
        $task->update([
            'body' => $request->body,
            'completed' => $request->has('completed')
        ]);

        return redirect($project->path());
    }
}
