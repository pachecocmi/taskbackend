<?php

namespace App\GraphQL\Mutations;

use App\Models\Task;

class TaskMutation
{
    /**
     * Create a new task.
     *
     * @param array $args
     * @return \App\Models\Task
     */
    public function createTask(array $args)
    {
        return Task::create($args);
    }

    /**
     * Update an existing task.
     *
     * @param array $args
     * @return \App\Models\Task|null
     */
    public function updateTask(array $args)
    {
        $task = Task::findOrFail($args['id']);
        $task->update($args);
        return $task;
    }

    /**
     * Delete an existing task.
     *
     * @param array $args
     * @return bool
     */
    public function deleteTask(array $args)
    {
        $task = Task::findOrFail($args['id']);
        $task->delete();
        return $task;
    }
}
