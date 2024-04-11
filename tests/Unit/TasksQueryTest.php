<?php

namespace Tests\Unit\GraphQL\Queries;

use App\GraphQL\Queries\TasksQuery;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksQueryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test tasks method with provided status.
     *
     * @return void
     */
    public function test_tasks_with_provided_status()
    {
        $activeTasks = Task::factory()->count(3)->create(['status' => Task::STATUS_TODO]);
        $completedTasks = Task::factory()->count(2)->create(['status' => Task::STATUS_DONE]);

        $query = new TasksQuery();
        $response = $query->tasks(['status' => Task::STATUS_TODO]);

        $this->assertCount(3, $response);
        $this->assertTrue($response->contains($activeTasks->first()));
        $this->assertFalse($response->contains($completedTasks->first()));
    }

    /**
     * Test tasks method without provided status.
     *
     * @return void
     */
    public function test_tasks_without_provided_status()
    {
        $activeTasks = Task::factory()->count(3)->create(['status' => Task::STATUS_TODO]);
        $completedTasks = Task::factory()->count(2)->create(['status' => Task::STATUS_DONE]);

        $query = new TasksQuery();
        $response = $query->tasks([]);

        $this->assertCount(3, $response);
        $this->assertTrue($response->contains($activeTasks->first()));
        $this->assertFalse($response->contains($completedTasks->first()));
    }

    /**
     * Test task method with existing task ID.
     *
     * @return void
     */
    public function test_task_with_existing_id()
    {
        $task = Task::factory()->create();

        $query = new TasksQuery();
        $response = $query->task(['id' => $task->id]);

        $this->assertEquals($task->id, $response->id);
    }

    /**
     * Test task method with non-existing task ID.
     *
     * @return void
     */
    public function test_task_with_non_existing_id()
    {
        $query = new TasksQuery();
        $response = $query->task(['id' => 999]);

        $this->assertNull($response);
    }
}
