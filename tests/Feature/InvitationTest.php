<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;


    // what do I want
    // Given that I have created a project.
    // I should be able to invite a user to my project
    // There should be a table that holds the invited users and their projects
    // A user other than me should not be able to invite someone to my projects
    // An invited user should not be able to delete my project

    /** @test */
    public function a_project_owner_should_be_able_to_add_members()
    {
        // create my project
        $user = $this->signIn();
        $project = ProjectSetup::owner($user)->create();

        // invite a user to my created project
        $project->invite($member = User::factory()->create());

        // invited user should exist in project_user table
        $assignedMember = $project->members->first();
        $this->assertInstanceOf(User::class, $assignedMember);
        $this->assertEquals($member->id, $assignedMember->id);

        // correct project_id should be assigned against a user
        $assignedProjectId = $project->members->first()->pivot;
        $this->assertEquals($project->id, $assignedProjectId->project_id);
    }

    /** @test */
    public function project_member_should_be_able_to_update_the_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetup::create();
        // invite a user to my created project
        $project->invite($member = $this->signIn());
        // attributes
        $attributes = ['title' => 'new title'];
        // send request as the new user
        $this->patch("/projects/{$project->id}", ['title' => 'new title'])->assertRedirect($project->path());
        // should be able to update it
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_project_member_can_create_a_task()
    {
        $this->withoutExceptionHandling();
        // give i have a project
        $project = ProjectSetup::create();
        // and owner of the project invites another user
        $project->invite($member = $this->signIn());
        // the invited user should have the permissions to add tasks
        $this->post("projects/{$project->id}/tasks", ['body' => 'task body'])->assertRedirect($project->path());
        // database should have the records
        $this->assertDatabaseHas('tasks', ['body' => 'task body']);
    }

    /** @test */
    public function a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetup::owner($this->signIn())->create();

        $user = User::factory()->create();

        $this->post($project->path() . '/invite', [
            'email' => $user->email
        ]);

        $this->assertTrue($project->members->contains($user));
    }

    /** @test */
    public function non_owners_may_not_invite_users_to_project()
    {
        $project = ProjectSetup::create();

        $user = User::factory()->create();

        $this->actingAs($user)->post(
            $project->path() . '/invite',
            [
                'email' => User::factory()->create()->email,
            ]
        )->assertStatus(403);

        $project->invite($user);

        $this->post(
            $project->path() . '/invite',
            [
                'email' => User::factory()->create()->email,
            ]
        )->assertStatus(403);
    }

    /** @test */
    public function a_member_may_not_delete_a_project()
    {
        $project = ProjectSetup::create();
        $this->signIn();
        $this->delete($project->path())->assertStatus(403);
        $sally = User::factory()->create();
        $project->invite($sally);
        $this->actingAs($sally)->delete($project->path())->assertStatus(403);
    }
}
