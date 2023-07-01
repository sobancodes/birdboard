<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('manage', $project);

        $request->validateWithBag('invitation', ['email' => 'required|exists:users,email']);

        $project->invite(User::whereEmail($request->email)->first());

        return redirect($project->path());
    }
}
