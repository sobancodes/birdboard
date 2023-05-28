<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Task;
use Facades\Tests\Setup\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetup::create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectSetup::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_task()
    {
        $project = ProjectSetup::create();

        $project->addTask('Add task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function (Activity $activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Add task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task()
    {
        $project = ProjectSetup::withTasks(1)->owner($this->signIn())->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'updated', 'completed' => true]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function (Activity $activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetup::withTasks(1)->owner($this->signIn())->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'updated', 'completed' => true]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), ['body' => 'updated', 'completed' => false]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        tap($project->activity->last(), function (Activity $activity) {
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectSetup::withTasks(1)->owner($this->signIn())->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
