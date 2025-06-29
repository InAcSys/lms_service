<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectStudent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubjectStudentController extends Controller
{
    const QUERY_PARAMS_MISSING = 'Required query parameters are missing. Please provide tenantId and subjectId.';
    const QUERY_PARAMS_MISSING_2 = 'Required query parameters are missing. Please provide tenantId and studentId.';
    public function index(
        Request $request
    ) {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $subjectStudents = SubjectStudent::where('tenantId', $tenantId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
            ->get('studentId')
            ->map(function ($item) {
                return $item->studentId;
            });

        return response()->json([
            'data' => $subjectStudents,
            'message' => 'Subject students retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function enrollStudents(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'studentIds' => 'required|array',
            'studentIds.*' => 'uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $studentIds = $request->input('studentIds');

        foreach ($studentIds as $studentId) {
            $affected = SubjectStudent::where('tenantId', $tenantId)
                ->where('subjectId', $subjectId)
                ->where('studentId', $studentId)
                ->update(['isActive' => true]);

            if ($affected === 0) {
                // No existía, crear nueva relación
                SubjectStudent::create([
                    'tenantId' => $tenantId,
                    'subjectId' => $subjectId,
                    'studentId' => $studentId,
                    'isActive' => true
                ]);
            }
        }

        return response()->json([
            'message' => 'Students enrolled or reactivated successfully.',
            'status' => 200
        ], 200);
    }

    public function unenrollStudents(Request $request)
    {
        $tenantId = $request->query('tenantId');
        $subjectId = $request->query('subjectId');

        if (!$tenantId || !$subjectId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'studentIds' => 'required|array',
            'studentIds.*' => 'uuid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $studentIds = $request->input('studentIds');

        foreach ($studentIds as $studentId) {
            SubjectStudent::where('tenantId', $tenantId)
                ->where('subjectId', $subjectId)
                ->where('studentId', $studentId)
                ->where('isActive', true)
                ->update([
                    'isActive' => false,
                    'deleted' => now(),
                    'updated' => now()
                ]);
        }


        return response()->json([
            'message' => 'Students revoked successfully.',
            'status' => 200
        ], 200);
    }

    public function getMySubjects(
        Request $request
    ) {
        $tenantId = $request->query('tenantId');
        $studentId = $request->query('studentId');

        if (!$tenantId || !$studentId) {
            return response()->json([
                'error' => self::QUERY_PARAMS_MISSING_2
            ], 400);
        }

        $subjects = SubjectStudent::where('tenantId', $tenantId)
            ->where('studentId', $studentId)
            ->where('isActive', true)
            ->get(['subjectId']);

        return response()->json([
            'data' => $subjects,
            'message' => 'My subjects retrieved successfully.',
            'status' => 200
        ], 200);
    }
}
