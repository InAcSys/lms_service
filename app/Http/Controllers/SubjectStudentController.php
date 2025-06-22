<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectStudent;
use Illuminate\Support\Facades\Validator;

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

        $subjectStudents = SubjectStudent::where('TenantId', $tenantId)
            ->where('SubjectId', $subjectId)
            ->where('IsActive', true)
            ->get('StudentId')
            ->map(function ($item) {
                return $item->StudentId;
            });

        return response()->json([
            'data' => $subjectStudents,
            'message' => 'Subject students retrieved successfully.',
            'status' => 200
        ], 200);
    }

    public function enrollStudents(
        Request $request
    ) {
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
            $existing = SubjectStudent::where('TenantId', $tenantId)
                ->where('SubjectId', $subjectId)
                ->where('StudentId', $studentId)
                ->first();

            if ($existing) {
                if (!$existing->IsActive) {
                    $existing->IsActive = true;
                    $existing->Deleted = null;
                    $existing->Updated = now();
                    $existing->save();
                }
            } else {
                SubjectStudent::create([
                    'SubjectId' => $subjectId,
                    'StudentId' => $studentId,
                    'TenantId' => $tenantId,
                    'IsActive' => true,
                    'Created' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Students enrolled successfully.',
            'status' => 201
        ], 201);
    }

    public function unenrollStudents(
        Request $request
    ) {
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
        SubjectStudent::where('TenantId', $tenantId)
            ->where('SubjectId', $subjectId)
            ->whereIn('StudentId', $studentIds)
            ->update(['IsActive' => false, 'Deleted' => now()]);

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

        $subjects = SubjectStudent::where('TenantId', $tenantId)
            ->where('StudentId', $studentId)
            ->where('IsActive', true)
            ->get(['SubjectId']);

        return response()->json([
            'data' => $subjects,
            'message' => 'My subjects retrieved successfully.',
            'status' => 200
        ], 200);
    }
}
