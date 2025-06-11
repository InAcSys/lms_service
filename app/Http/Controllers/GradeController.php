<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    private const GRADE_NOT_FOUND = 'Grade not found';

    public function index(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $pageNumber = $request->query('pageNumber', 1);
        $pageSize = $request->query('pageSize', 1);

        $query = Grade::query();

        if ($tenantId) {
            $query->where('tenantId', $tenantId);
        }

        $query->where('isActive', true);
        $grades = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        $totalPages = $grades->lastPage();

        if ($pageNumber > $totalPages) {
            return response()->json([
                'message' => 'Page number exceeds total pages',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'data' => $grades->items(),
            'total' => $grades->total(),
            'current_page' => $grades->currentPage(),
            'per_page' => $grades->perPage(),
            'total_pages' => $totalPages,
            'status' => 200
        ], 200);
    }

    public function show($id, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $grade = Grade::where('id', $id)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->first();

        if ($grade) {
            return response()->json([
                'message' => self::GRADE_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Grade found',
            'data' => $grade,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taskId' => 'required|integer|exists:tasks,id',
            'studentId' => 'required|uuid',
            'grade' => 'required|numeric|min:0|max:100',
            'comment' => 'nullable|string|max:255',
            'tenantId' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }
        $validateData = $validator->validated();

        $query = Grade::where('tenantId', $validateData['tenantId'])
            ->where('taskId', $validateData['taskId'])
            ->where('studentId', $validateData['studentId']);

        $grade = $query->first();

        if ($grade && !$grade->isActive) {
            $grade->isActive = true;
            $grade->save();
            return response()->json([
                'message' => 'Grade reactivated successfully and was activated',
                'status' => 200
            ], 200);
        }

        $grade = Grade::create($validateData);

        return response()->json([
            'message' => 'Grade created successfully',
            'data' => $grade,
            'status' => 201
        ], 201);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|numeric|min:0|max:100',
            'comment' => 'nullable|string|max:255',
            'tenantId' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $validateData = $validator->validated();

        $grade = Grade::where('id', $id)
            ->where('tenantId', $validateData['tenantId'])
            ->where('isActive', true)
            ->first();

        if (!$grade) {
            return response()->json([
                'message' => self::GRADE_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        $grade->update($validateData);

        return response()->json([
            'message' => 'Grade updated successfully',
            'data' => $grade,
            'status' => 200
        ], 200);
    }

    public function destroy($id, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $grade = Grade::where('id', $id)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->first();

        if (!$grade) {
            return response()->json([
                'message' => self::GRADE_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        $grade->isActive = false;
        $grade->save();

        return response()->json([
            'message' => 'Grade deleted successfully',
            'status' => 200
        ], 200);
    }

    public function showByTaskId($taskId, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $grades = Grade::where('taskId', $taskId)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->get();

        if ($grades->isEmpty()) {
            return response()->json([
                'message' => 'No grades found for this task',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => $grades,
            'status' => 200
        ], 200);
    }

    public function showByStudentId($studentId, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $grades = Grade::where('studentId', $studentId)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->get();

        if ($grades->isEmpty()) {
            return response()->json([
                'message' => 'No grades found for this student',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => $grades,
            'status' => 200
        ], 200);
    }

    public function showByTaskAndStudentId($taskId, $studentId, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $grade = Grade::where('taskId', $taskId)
            ->where('studentId', $studentId)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->first();

        if (!$grade) {
            return response()->json([
                'message' => self::GRADE_NOT_FOUND,
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => $grade,
            'status' => 200
        ], 200);
    }
}
