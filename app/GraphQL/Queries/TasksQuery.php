<?php

namespace App\GraphQL\Queries;

use App\Models\Task;

class TasksQuery
{
    /**
     * Retrieve tasks based on provided status.
     * If status is not provided, only active tasks are returned.
     *
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tasks(array $args)
    {
        // assume/force 1 if $args['status'] is blank, this means only active classes should be listed if not set
        if (!isset($args['status'])) {
            $args['status'] = Task::STATUS_TODO;
        }

        $query = Task::query();

        if (isset($args['status'])) {
            $query->where('status', $args['status']);
        }

        return $query->get();
    }

    /**
     * Retrieve a single task by ID.
     *
     * @param array $args
     * @return \App\Models\Task|null - null for non existing/invalid ids
     */
    public function task(array $args)
    {
        return Task::find($args['id']);
    }
}
