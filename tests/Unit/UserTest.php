<?php

namespace Tests\Unit;

use App\Models\User;
use Facades\Tests\Setup\ProjectSetup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function has_projects()
    {
        $user = User::factory()->create();

        // checking that if we call the relationship method then it returns the collection of projects
        // if the relationship does not exists then null will be returned
        $this->assertInstanceOf(EloquentCollection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();

        ProjectSetup::owner($john)->create();

        $this->assertCount(1, $john->accessibleProjects());
    }
}
