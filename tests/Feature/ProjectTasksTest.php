<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectSetup;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_tasks_to_project()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function a_user_cannot_add_tasks_to_project_they_do_not_own()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function a_user_cannot_add_task_they_do_not_own()
    {
        $this->signIn();

        $project = ProjectSetup::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    // if you are struggling to write tests, assume yourself as a client requesting some new feature
    // & you have to explain yourself to developer
    // in this case i could say that i want a feature that the project has tasks
    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectSetup::owner($this->signIn())->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectSetup::owner($this->signIn())->create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectSetup::owner($this->signIn())->withTasks(1)->create();

        $attributes = [
            'body' => 'changed',
            'completed' => true,
        ];

        $this->patch($project->tasks[0]->path(), $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }
}
