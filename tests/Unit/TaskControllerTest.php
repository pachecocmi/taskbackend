<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing tasks.
     * Result: Success (200)
     *
     * @return void
     */
    public function test_list_tasks()
    {
        Task::factory()->count(5)->create();

        // get active tasks
        $response = $this->postJson('/task/list');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['success', 'data']);

        // get completed tasks
        $response = $this->postJson('/task/list', ['status' => 1]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['success', 'data']);
    }

    /**
     * Test creating a task.
     * Result: Success (200)
     *
     * @return void
     */
    public function test_create_task()
    {
        $data = [
            'description' => 'New Task Description',
        ];

        $response = $this->postJson('/task/create', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'msg' => 'Task Added Successfully',
        ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Test updating a task.
     * Result: Success (200)
     *
     * @return void
     */
    public function test_update_task()
    {
        $task = Task::factory()->create();

        $data = [
            'id' => $task->id,
            'description' => 'Updated Task Description',
        ];

        $response = $this->postJson('/task/update', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'msg' => 'Task Updated Successfully',
        ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Test completing a task.
     * Result: Success (200)
     *
     * @return void
     */
    public function test_complete_task()
    {
        $task = Task::factory()->create();

        $data = [
            'id' => $task->id,
        ];

        $response = $this->postJson('/task/complete', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'msg' => 'Task has been completed',
        ]);

        $this->assertTrue(Task::find($task->id)->isCompleted());
    }

    /**
     * Test deleting a task.
     * Result: Success (200)
     *
     * @return void
     */
    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $data = [
            'id' => $task->id,
        ];

        $response = $this->postJson('/task/delete', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'msg' => 'Task Removed Successfully',
        ]);

        // check if removed.
        $this->assertTrue(!Task::find($task->id));
    }
}
