<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentCourse;

class StudentCourseController extends Controller
{
    private const STUDENT_COURSE_NOT_FOUND = 'Student Course not found';

    public function index(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $pageNumber = $request->query('pageNumber', 1);
        $pageSize = $request->query('pageSize', 10);

        $query = StudentCourse::query();
        if ($tenantId) {
            $query->where('tenantId', $tenantId);
        }

        $query->where('isActive', true);
        $studentCourses = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        return response()->json([
            'data' => $studentCourses->items(),
            'total' => $studentCourses->total(),
            'current_page' => $studentCourses->currentPage(),
            'per_page' => $studentCourses->perPage(),
            'status' => 200
        ], 200);
    }


    public function show($id, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $studentCourse = StudentCourse::where('id', $id)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->firstOrFail();

        if (!$studentCourse) {
            $data = [
                'message' => self::STUDENT_COURSE_NOT_FOUND,
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json([
            'data' => $studentCourse,
            'status' => 200
        ], 200);
    }

    public function showByStudentId($studentId, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $studentCourse = StudentCourse::where('studentId', $studentId)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->firstOrFail();

        if (!$studentCourse) {
            $data = [
                'message' => self::STUDENT_COURSE_NOT_FOUND,
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json([
            'data' => $studentCourse,
            'status' => 200
        ], 200);
    }

    public function showByCourseId($courseId, Request $request)
    {
        $tenantId = $request->query('tenantId');

        $studentCourse = StudentCourse::where('courseId', $courseId)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->where('isActive', true)
            ->firstOrFail();

        if (!$studentCourse) {
            $data = [
                'message' => self::STUDENT_COURSE_NOT_FOUND,
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json([
            'data' => $studentCourse,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'courseId' => 'required|uuid',
            'studentId' => 'required|uuid',
            'tenantId' => 'nullable|uuid',
        ]);
        if (!$validateData) {
            $data = [
                'message' => 'Invalid data provided',
                'status' => 422
            ];
            return response()->json($data, 422);
        }

        $query = StudentCourse::where('courseId', $request->courseId)
            ->where('studentId', $request->studentId);

        if ($request->filled('tenantId')) {
            $query->where('tenantId', $request->tenantId);
        }

        $studentCourse = $query->first();

        if ($studentCourse && !$studentCourse->isActive) {
            $studentCourse->isActive = true;
            $studentCourse->save();
            $data = [
                'message' => 'Student Course already existed and was reactivated',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $studentCourse = StudentCourse::create(array_merge($request->all(), ['isActive' => true]));
        $data = [
            'message' => 'Student Course created successfully',
            'data' => $studentCourse,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $response = null;

        $validateData = $request->validate([
            'courseId' => 'sometimes|uuid',
            'studentId' => 'sometimes|uuid',
            'tenantId' => 'nullable|uuid',
        ]);

        if (!$validateData) {
            $response = [
                'message' => 'Invalid data provided',
                'status' => 422
            ];
        } elseif (!$request->has('courseId') && !$request->has('studentId')) {
            $response = [
                'message' => 'At least one of courseId or studentId must be provided',
                'status' => 422
            ];
        } else {
            $studentCourse = StudentCourse::where('id', $id)
                ->where('isActive', true)
                ->when($request->query('tenantId'), fn($query) => $query->where('tenantId', $request->query('tenantId')))
                ->first();

            if (!$studentCourse) {
                $response = [
                    'message' => self::STUDENT_COURSE_NOT_FOUND,
                    'status' => 404
                ];
            } else {
                $studentCourse->update($request->all());
                $studentCourse->save();
                $response = [
                    'message' => 'Student Course updated successfully',
                    'status' => 200
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

    public function destroy(Request $request, $id)
    {
        $tenantId = $request->query('tenantId');

        $studentCourse = StudentCourse::where('id', $id)
            ->when($tenantId, fn($query) => $query->where('tenantId', $tenantId))
            ->firstOrFail();
        if (!$studentCourse) {
            $data = [
                'message' => self::STUDENT_COURSE_NOT_FOUND,
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $studentCourse->isActive = false;
        $studentCourse->save();

        $data = [
            'message' => 'Student Course deleted successfully',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
