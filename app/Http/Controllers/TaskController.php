<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    const QUERY_PARAMS_MISSING = 'Required query parameters are missing. Please provide tenantId and subjectId.';
    const TASK_NOT_FOUND_ERROR = 'Task not found or does not belong to the specified tenant or subject.';

    public function index(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $tasks = Task::where('TenantId', $tenantId)
            ->where('SubjectId', $subjectId)
            ->where('IsActive', true)
            ->get();

        return response()->json([
            'data' => $tasks,
            'message' => 'Tasks retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function show($id, Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $task = Task::where('Id', $id)
            ->where('TenantId', $tenantId)
            ->where('SubjectId', $subjectId)
            ->where('IsActive', true)
            ->first();

        if (!$task) {
            return response()->json([
                'error' => self::TASK_NOT_FOUND_ERROR
            ], 404);
        }

        return response()->json([
            'data' => $task,
            'message' => 'Task retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $task = Task::create([
            'Title' => $request->input('Title'),
            'Description' => $request->input('Description'),
            'DueDate' => $request->input('DueDate') ? now()->parse($request->input('DueDate')) : now() + '1 day',
            'SubjectId' => $subjectId,
            'TenantId' => $tenantId,
            'IsActive' => true,
            'Created' => now(),
        ]);

        return response()->json([
            'data' => $task,
            'message' => 'Task created successfully.',
            'status' => 201
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $task = Task::find($id);
        if (!$task || $task->TenantId !== $tenantId || $task->SubjectId !== $subjectId) {
            return response()->json([
                'error' => self::TASK_NOT_FOUND_ERROR
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'DueDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $task->Title = $request->input('Title');
        $task->Description = $request->input('Description');
        if ($request->has('DueDate')) {
            $task->DueDate = now()->parse($request->input('DueDate'));
        }
        $task->Updated = now();
        $task->save();

        return response()->json([
            'data' => $task,
            'message' => 'Task updated successfully.',
            'status' => 200
        ], 200);
    }

    public function destroy($id, Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $task = Task::find($id);

        if (!$task || $task->TenantId !== $tenantId || $task->SubjectId !== $subjectId) {
            return response()->json([
                'error' => 'Task not found or does not belong to the specified tenant or subject.'
            ], 404);
        }

        $task->IsActive = false;
        $task->Deleted = now();
        $task->save();

        return response()->json([
            'message' => 'Task deleted successfully.',
            'status' => 200
        ], 200);
    }
}
