<?php

namespace App\Http\Controllers;

use App\GraphQL\Queries\TasksQuery;
use App\GraphQL\Mutations\TaskMutation;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * List tasks all tasks. List only active(0) tasks by default.
     * Use this to list completed tasks as well by setting status to completed(1)
     * POST: /task/list
     *
     * @param Request $request
     * @param TasksQuery $query
     * @return JsonResponse
     */
    public function list(Request $request, TasksQuery $query): JsonResponse
    {
        try {
            // validate status request for listing.
            $args = $request->validate([
                'status' => 'sometimes|required|numeric|in:0,1',
            ]);

            $response = $query->tasks($args);
            return response()->json(['success' => true, 'data' => $response]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new task and return ID as response
     * POST: /task/create
     *
     * @param Request $request
     * @param TaskMutation $task
     * @return JsonResponse
     */
    public function create(Request $request, TaskMutation $task): JsonResponse
    {
        try {
            $args = $request->validate([
                'description' => 'required|string',
            ]);

            $args['status'] = Task::STATUS_TODO;
            $response = $task->createTask($args);
            if (!$response) {
                throw new Exception('Task creation failed. Please try again later.');
            }

            return response()->json(['success' => true, 'msg' => 'Task Added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a task description
     * POST: /task/update
     *
     * @param Request $request
     * @param TaskMutation $task
     * @return JsonResponse
     */
    public function update(Request $request, TaskMutation $task): JsonResponse
    {
        try {
            $args = $request->validate([
                'id' => 'required|numeric',
                'description' => 'required|string',
            ]);

            // filter through strings for invalid parse response
            $response = $task->updateTask($args);

            if (!$response) {
                throw new Exception('Task update failed. Please try again later.');
            }
            return response()->json(['success' => true, 'msg' => 'Task Updated Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Set task as completed. No status change needed from frontend.
     * POST: /task/complete
     *
     * @param Request $request
     * @param TaskMutation $task
     * @return JsonResponse
     */
    public function complete(Request $request, TaskMutation $task): JsonResponse
    {
        try {
            $args = $request->validate([
                'id' => 'required|numeric',
            ]);

            $args['status'] = Task::STATUS_DONE;
            $response = $task->updateTask($args);

            if (!$response) {
                throw new Exception('Task update failed. Please try again later.');
            }
            return response()->json(['success' => true, 'msg' => 'Task has been completed']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a task from the list
     * POST: /task/delete
     *
     * @param Request $request
     * @param TaskMutation $task
     * @return JsonResponse
     */
    public function delete(Request $request, TaskMutation $task): JsonResponse
    {
        try {
            $args = $request->validate([
                'id' => 'required|numeric',
            ]);

            $response = $task->deleteTask($args);
            if (!$response) {
                throw new Exception('Task removal failed. Please try again later.');
            }
            return response()->json(['success' => true, 'msg' => 'Task Removed Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
