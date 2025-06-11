<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    private const TASK_NOT_FOUND = 'Task not found';

    public function index(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $pageNumber = $request->query('pageNumber', 1);
        $pageSize = $request->query('pageSize', 10);

        $query = Task::query();
        if ($tenantId) {
            $query->where('tenantId', $tenantId);
        }

        $query->where('isActive', true);
        $tasks = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        $totalPages = $tasks->lastPage();

        if ($pageNumber > $totalPages) {
            return response()->json([
                'message' => 'Page number exceeds total pages',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'data' => $tasks->items(),
            'total' => $tasks->total(),
            'current_page' => $tasks->currentPage(),
            'per_page' => $tasks->perPage(),
            'total_pages' => $totalPages,
            'status' => 200
        ], 200);
    }

    public function show($id, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $task = Task::where('id', $id)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->first();

        if (!$task) {
            return response()->json([
                'message' => self::TASK_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Task found',
            'data' => $task,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'dueDate' => 'required|date_format:Y-m-d H:i:s',
            'courseId' => 'required|uuid',
            'tenantId' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $validateData = $validator->validated();

        $query = Task::where('title', $validateData['title'])
            ->where('description', $validateData['description'])
            ->where('dueDate', $validateData['dueDate'])
            ->where('courseId', $validateData['courseId'])
            ->where('tenantId', $validateData['tenantId']);

        $task = $query->first();

        if ($task && !$task->isActive) {
            $task->isActive = true;
            $task->save();
            return response()->json([
                'message' => 'Task reactivated successfully and was activated',
                'data' => $task,
                'status' => 200
            ], 200);
        }

        $task = Task::create($validateData);

        $data = [
            'message' => 'Task created successfully',
            'data' => $task,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'dueDate' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'courseId' => 'sometimes|required|uuid',
            'tenantId' => 'sometimes|required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $task = Task::find($id);

        if (!$task || !$task->isActive) {
            return response()->json([
                'message' => self::TASK_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        $task->update($validator->validated());

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task || !$task->isActive) {
            return response()->json([
                'message' => self::TASK_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        $task->isActive = false;
        $task->save();

        return response()->json([
            'message' => 'Task deleted successfully',
            'status' => 200
        ], 200);
    }
}
