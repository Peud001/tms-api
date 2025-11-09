<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->tasks();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = min($request->get('per_page', 10), 100);

        return TaskResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created task for the authenticated user.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());

        return new TaskResource($task);
    }

    /**
     * Display the specified task if it belongs to the authenticated user.
     */
    public function show(Task $task, Request $request)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified task if it belongs to the authenticated user.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified task if it belongs to the authenticated user.
     */
    public function destroy(Task $task, Request $request)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
