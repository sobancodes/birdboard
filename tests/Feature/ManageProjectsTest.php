<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * How does this test work?
     * This is a middleware level test instead of request validation test
     * We pass all the data (title, description) in this case
     * However to access this route / method user should be signed in. So we added a middleware on the route
     * Here in the test, we don't have the user signed in. So when they try to access the method
     * we make sure that the redirect exists to the login page.
     */
    /** @test */
    public function a_project_requires_an_owner()
    {
        $attributes = Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => $this->faker->paragraph(),
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectSetup::owner($this->signIn())->create();

        $this->patch($project->path(), $attributes = [
            'title' => 'changed', 'description' => 'changed', 'notes' => 'changed'
        ])->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_note_field() {
        $project = ProjectSetup::owner($this->signIn())->create();

        $attributes = ['notes' => 'changed'];

        $this->patch($project->path(), $attributes);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectSetup::owner($this->signIn())->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    // need to validate that we are throwing a title error if title is missing
    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    // need to validate that we are throwing a description error if description is missing
    /** @test */
    public function a_project_requires_a_descrition()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function guest_cannot_create_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);
    }
}
