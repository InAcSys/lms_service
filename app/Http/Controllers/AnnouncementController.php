<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    const QUERY_PARAMS_MISSING = 'Required query parameters are missing. Please provide tenantId and subjectId.';
    const QUERY_PARAMS_MISSING_2 = 'Required query parameters are missing. Please provide tenantId and authorId.';
    const QUERY_PARAMS_MISSING_3 = 'Required query parameter is missing. Please provide tenantId.';
    const QUERY_PARAMS_MISSING_4 = 'Required query parameters are missing. Please provide subjectId, tenantId and authorId.';
    const ANNOUNCEMENT_NOT_FOUND_ERROR = 'Announcement not found or does not belong to the specified tenant or subject.';

    public function index(Request $request)
    {
        $subjectId = $request->query('subjectId');
        $tenantId = $request->query('tenantId');

        if (!$tenantId || !$subjectId) {
            return response()->json(
                [
                    'error' => self::QUERY_PARAMS_MISSING,
                    'status' => 400
                ],
                400
            );
        }

        $announcements = Announcement::where('tenantId', $tenantId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
            ->orderByRaw('COALESCE(updated, created) DESC')
            ->get();

        return response()->json(
            [
                'data' => $announcements,
                'message' => 'Announcements retrieved successfully.',
                'status' => 200
            ],
            200
        );
    }

    public function show($id, Request $request)
    {
        $subjectId = $request->query('subjectId');
        $tenantId = $request->query('tenantId');

        if (!$tenantId || !$subjectId) {
            return response()->json(
                [
                    'error' => self::QUERY_PARAMS_MISSING,
                    'status' => 400
                ],
                400
            );
        }

        $announcement = Announcement::where('id', $id)
            ->where('tenantId', $tenantId)
            ->where('subjectId', $subjectId)
            ->where('isActive', true)
            ->first();

        if (!$announcement) {
            return response()->json(
                [
                    'error' => self::ANNOUNCEMENT_NOT_FOUND_ERROR,
                    'status' => 404
                ],
                404
            );
        }

        return response()->json(
            [
                'data' => $announcement,
                'message' => 'Announcement retrieved successfully.',
                'status' => 200
            ],
            200
        );
    }

    public function store($id, Request $request)
    {
        $subjectId = $request->query('subjectId');
        $tenantId = $request->query('tenantId');

        if (!$tenantId || !$subjectId) {
            return response()->json(
                [
                    'error' => self::QUERY_PARAMS_MISSING,
                    'status' => 400
                ],
                400
            );
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

        $announcement = Announcement::create(
            [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'tenantId' => $tenantId,
                'authorId' => $id,
                'subjectId' => $subjectId,
                'isActive' => true,
                'created' => now(),
            ]
        );

        return response()->json([
            'data' => $announcement,
            'message' => 'Announcement created successfully.',
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

        $announcement = Announcement::find($id);
        if (!$announcement || $announcement->tenantId !== $tenantId || $announcement->subjectId !== $subjectId) {
            return response()->json([
                'error' => self::ANNOUNCEMENT_NOT_FOUND_ERROR
            ], 404);
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

        $announcement->title = $request->input('title');
        $announcement->description = $request->input('description');
        $announcement->updated = now();
        $announcement->save();

        return response()->json([
            'data' => $announcement,
            'message' => 'Announcement updated successfully.',
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

        $announcement = Announcement::find($id);

        if (!$announcement || $announcement->tenantId !== $tenantId || $announcement->subjectId !== $subjectId) {
            return response()->json([
                'error' => 'Announcement not found or does not belong to the specified tenant or subject.'
            ], 404);
        }

        $announcement->isActive = false;
        $announcement->deleted = now();
        $announcement->save();

        return response()->json([
            'message' => 'Announcement deleted successfully.',
            'status' => 200
        ], 200);
    }
}
