<?php

use App\Http\Controllers\SubjectStudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('subject-students')->group(function () {
    Route::get('/students', [SubjectStudentController::class, 'index']);
    Route::get('/my-subjects', [SubjectStudentController::class, 'getMySubjects']);
    Route::post('/enroll', [SubjectStudentController::class, 'enrollStudents']);
    Route::delete('/unenroll', [SubjectStudentController::class, 'unenrollStudents']);
});
