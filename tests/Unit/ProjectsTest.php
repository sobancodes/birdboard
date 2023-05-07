<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_path()
    {
        $project = Project::factory()->make();

        $this->assertEquals($project->path(), '/projects/' . $project->id);
    }

    /** @test */
    public function a_project_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_add_a_task() {
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
