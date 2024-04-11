<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test isActive method when task is active.
     *
     * @return void
     */
    public function test_isActive_when_active()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_TODO]);

        $this->assertTrue($task->isActive());
    }

    /**
     * Test isActive method when task is not active.
     *
     * @return void
     */
    public function test_isActive_when_not_active()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_DONE]);

        $this->assertFalse($task->isActive());
    }

    /**
     * Test isCompleted method when task is completed.
     *
     * @return void
     */
    public function test_isCompleted_when_completed()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_DONE]);

        $this->assertTrue($task->isCompleted());
    }

    /**
     * Test isCompleted method when task is not completed.
     *
     * @return void
     */
    public function test_isCompleted_when_not_completed()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_TODO]);

        $this->assertFalse($task->isCompleted());
    }

    /**
     * Test setStatus method with valid status.
     *
     * @return void
     */
    public function test_setStatus_with_valid_status()
    {
        $task = Task::factory()->create();

        $task->setStatus(Task::STATUS_DONE);

        $this->assertEquals(Task::STATUS_DONE, $task->status);
    }

    /**
     * Test setStatus method with invalid status.
     *
     * @return void
     */
    public function test_setStatus_with_invalid_status()
    {
        $this->expectException(Exception::class);

        $task = Task::factory()->create();

        $task->setStatus(2); // Invalid status
    }
}
