<?php

use App\Http\Controllers\SubjectStudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

const TASK_ID_ROUTE = '/{id}';

Route::prefix('subject-students')->group(function () {
    Route::get('/students', [SubjectStudentController::class, 'index']);
    Route::get('/my-subjects', [SubjectStudentController::class, 'getMySubjects']);
    Route::post('/enroll', [SubjectStudentController::class, 'enrollStudents']);
    Route::delete('/unenroll', [SubjectStudentController::class, 'unenrollStudents']);
});

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get(TASK_ID_ROUTE, [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put(TASK_ID_ROUTE, [TaskController::class, 'update']);
    Route::delete(TASK_ID_ROUTE, [TaskController::class, 'destroy']);
    Route::prefix('submitted')->group(function () {
        Route::get('/task/{id}', [TaskController::class, 'getSubmittedTask']);
        Route::get('/tasks/{id}', [TaskController::class, 'showSubmittedTasks']);
        Route::post('/{id}', [TaskController::class, 'submitResolution']);
    });
    Route::prefix('grades')->group(function () {
        Route::get('/', [TaskController::class, 'getStudentGradesBySubject']);
        Route::get('/task/{id}', [TaskController::class, 'getStudentGradeByTask']);
        Route::post('/assign/{id}', [TaskController::class, 'assignGrade']);
    });
});

Route::prefix('announcement')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index']);
    Route::get('/{id}', [AnnouncementController::class, 'show']);
    Route::post('/{id}', [AnnouncementController::class, 'store']);
});
