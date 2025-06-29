<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubmittedTask;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    const QUERY_PARAMS_MISSING = 'Required query parameters are missing. Please provide tenantId and subjectId.';
    const QUERY_PARAMS_MISSING_2 = 'Required query parameters are missing. Please provide tenantId and studentId.';
    const QUERY_PARAMS_MISSING_3 = 'Required query parameter is missing. Please provide tenantId.';
    const QUERY_PARAMS_MISSING_4 = 'Required query parameters are missing. Please provide subjectId, tenantId and studentId.';
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

        $tasks = Task::where('tenantId', $tenantId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
            ->orderBy('dueDate', 'asc')
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

        $task = Task::where('id', $id)
            ->where('tenantId', $tenantId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'dueDate' => $request->input('dueDate') ? now()->parse($request->input('dueDate')) : now() + '1 day',
            'subjectId' => $subjectId,
            'tenantId' => $tenantId,
            'isActive' => true,
            'created' => now(),
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
        if (!$task || $task->tenantId !== $tenantId || $task->subjectId !== $subjectId) {
            return response()->json([
                'error' => self::TASK_NOT_FOUND_ERROR
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dueDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        if ($request->has('dueDate')) {
            $task->dueDate = now()->parse($request->input('dueDate'));
        }
        $task->updated = now();
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

        if (!$task || $task->tenantId !== $tenantId || $task->subjectId !== $subjectId) {
            return response()->json([
                'error' => 'Task not found or does not belong to the specified tenant or subject.'
            ], 404);
        }

        $task->isActive = false;
        $task->deleted = now();
        $task->save();

        return response()->json([
            'message' => 'Task deleted successfully.',
            'status' => 200
        ], 200);
    }

    public function getSubmittedTask(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');

        if (!$tenantId || !$studentId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING_2
            ], 400);
        }

        $submittedTask = SubmittedTask::where('taskId', $id)
            ->where('studentId', $studentId)
            ->where('tenantId', $tenantId)
            ->where('isActive', true)
            ->first();

        if (!$submittedTask) {
            return response()->json([
                'message' => 'No submitted task found for the given parameters.',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => $submittedTask,
            'message' => 'Submitted task retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function showSubmittedTasks($id, Request $request)
    {
        $tenantId = $request->query('tenantId');

        if (!$tenantId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING_3
            ], 400);
        }

        $submittedTasks = SubmittedTask::where('taskId', $id)
            ->where('tenantId', $tenantId)
            ->where('isActive', true)
            ->get();

        return response()->json([
            'data' => $submittedTasks,
            'message' => 'Submitted tasks retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function submitResolution(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');

        if (!$tenantId || !$studentId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING_2
            ], 400);
        }

        $task = Task::find($id);

        if (!$task || $task->tenantId !== $tenantId) {
            return response()->json([
                'error' => self::TASK_NOT_FOUND_ERROR
            ], 404);
        }

        $contents = $request->input('content', []);

        if (!is_array($contents) || count($contents) > 10) {
            return response()->json([
                'message' => 'Content must be an array with a maximum of 10 items.'
            ], 422);
        }

        $submittedTask = SubmittedTask::create([
            'content' => json_encode($contents),
            'taskId' => $id,
            'studentId' => $studentId,
            'tenantId' => $tenantId,
            'isActive' => true,
            'created' => now(),
        ]);

        return response()->json([
            'message' => 'Task resolution sent successfully.',
            'data' => $submittedTask,
            'status' => 200
        ], 200);
    }

    public function getStudentGradesBySubject(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$studentId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $grades = Grade::where('tenantId', $tenantId)
            ->where('studentId', $studentId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
            ->get();

        $data = [
            'grades' => $grades,
            'average' => $grades->avg('grade'),
            'highest' => $grades->max('grade'),
            'lowest' => $grades->min('grade')
        ];

        return response()->json([
            'data' => $data,
            'message' => 'Grades retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function getStudentGradeByTask(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');

        if (!$tenantId || !$studentId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING_2
            ], 400);
        }

        $grade = Grade::where('tenantId', $tenantId)
            ->where('studentId', $studentId)
            ->where('taskId', $id)
            ->where('isActive', true)
            ->first();

        if (!$grade) {
            return response()->json([
                'message' => 'No grade found for the given task.',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => $grade,
            'message' => 'Grade retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function assignGrade(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');
        $subjectId = $request->query('subjectId');

        $task = Task::find($id);

        if (!$task) {
            return response()->json(
                [
                    'message' => 'Task not found',
                    'status' => 404
                ],
                404
            );
        }

        if (!$tenantId || !$studentId || !$subjectId) {
            return response()->json(
                [
                    'message' => self::QUERY_PARAMS_MISSING_4,
                    'status' => 400
                ],
                400
            );
        }

        $validator = Validator::make($request->all(), [
            'grade' => 'required|numeric|decimal:0,2|min:0|max:100',
            'comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Invalid request',
                    'errors' => $validator->errors(),
                    'status' => 400
                ],
                400
            );
        }

        $grade = Grade::create([
            'tenantId' => $tenantId,
            'studentId' => $studentId,
            'subjectId' => $subjectId,
            'taskId' => $id,
            'grade' => $request->input('grade'),
            'comment' => $request->input('comment'),
            'isActive' => true,
            'created' => now(),
        ]);

        return response()->json(
            [
                'data' => $grade,
                'message' => 'Grade assigned successfully',
                'status' => 201
            ],
            201
        );
    }
}
