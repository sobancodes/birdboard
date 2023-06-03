<?php

namespace Tests\Unit;

use Facades\Tests\Setup\ProjectSetup;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_has_a_user()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $project = ProjectSetup::owner($user)->create();

        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
