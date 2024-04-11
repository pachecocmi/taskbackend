<?php

namespace Tests\Unit\GraphQL\Mutations;

use App\GraphQL\Mutations\TaskMutation;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskMutationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test createTask method.
     *
     * @return void
     */
    public function test_createTask()
    {
        $mutation = new TaskMutation();
        $args = [
            'description' => 'New Task Description',
            'status' => Task::STATUS_TODO,
        ];

        $task = $mutation->createTask($args);

        $this->assertDatabaseHas('tasks', $args);
        $this->assertInstanceOf(Task::class, $task);
    }

    /**
     * Test updateTask method with existing task.
     *
     * @return void
     */
    public function test_updateTask_with_existing_task()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_TODO]);

        $mutation = new TaskMutation();
        $args = [
            'id' => $task->id,
            'description' => 'Updated Task Description',
        ];

        $updatedTask = $mutation->updateTask($args);

        $this->assertEquals($args['description'], $updatedTask->description);
    }

    /**
     * Test updateTask method with non-existing task.
     *
     * @return void
     */
    public function test_updateTask_with_non_existing_task()
    {
        $mutation = new TaskMutation();
        $args = [
            'id' => 999,
            'description' => 'Updated Task Description',
        ];

        $updatedTask = $mutation->updateTask($args);

        $this->assertNull($updatedTask);
    }

    /**
     * Test deleteTask method with existing task.
     *
     * @return void
     */
    public function test_deleteTask_with_existing_task()
    {
        $task = Task::factory()->create(['status' => Task::STATUS_TODO]);
        $mutation = new TaskMutation();
        $args = [
            'id' => $task->id,
        ];

        $deleted = $mutation->deleteTask($args);

        $this->assertTrue($deleted);
        // assume deleted
        $this->assertTrue(!Task::find($task->id));
    }

    /**
     * Test deleteTask method with non-existing task.
     *
     * @return void
     */
    public function test_deleteTask_with_non_existing_task()
    {
        $mutation = new TaskMutation();
        $args = [
            'id' => 999,
        ];

        $deleted = $mutation->deleteTask($args);
        var_dump($deleted); die;
        $this->assertFalse($deleted);
    }
}
