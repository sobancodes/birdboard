<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_path() {
        $project = Project::factory()->make();

        $this->assertEquals($project->path(), '/projects/' . $project->id);
    }
}