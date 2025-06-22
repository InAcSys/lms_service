<?php

use App\Http\Controllers\SubjectStudentController;
use Illuminate\Support\Facades\Route;

const TASK_ID_ROUTE = '/{id}';

Route::prefix('subject-students')->group(function () {
    Route::get('/students', [SubjectStudentController::class, 'index']);
    Route::get('/my-subjects', [SubjectStudentController::class, 'getMySubjects']);
    Route::post('/enroll', [SubjectStudentController::class, 'enrollStudents']);
    Route::delete('/unenroll', [SubjectStudentController::class, 'unenrollStudents']);
});

Route::prefix('tasks')->group(function () {
    Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
    Route::get(TASK_ID_ROUTE, [App\Http\Controllers\TaskController::class, 'show']);
    Route::post('/', [App\Http\Controllers\TaskController::class, 'store']);
    Route::put(TASK_ID_ROUTE, [App\Http\Controllers\TaskController::class, 'update']);
    Route::delete(TASK_ID_ROUTE, [App\Http\Controllers\TaskController::class, 'destroy']);
});
