<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate(['body' => 'required']);

        $project->addTask($request->body);

        return redirect($project->path());
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $task->update($request->validate(['body' => 'required']));

        $request->completed ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }
}
