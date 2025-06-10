<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Routes

// Student Course Routes

const STUDENT_COURSE_ID_ROUTE = '/student-courses/{id}';

Route::get('/student-courses', [App\Http\Controllers\StudentCourseController::class, 'index']);
Route::get(STUDENT_COURSE_ID_ROUTE, [App\Http\Controllers\StudentCourseController::class, 'show']);
Route::post('/student-courses', [App\Http\Controllers\StudentCourseController::class, 'store']);
Route::put(STUDENT_COURSE_ID_ROUTE, [App\Http\Controllers\StudentCourseController::class, 'update']);
Route::delete(STUDENT_COURSE_ID_ROUTE, [App\Http\Controllers\StudentCourseController::class, 'destroy']);
Route::get('/student-courses/student/{studentId}', [App\Http\Controllers\StudentCourseController::class, 'showByStudentId']);
Route::get('/student-courses/course/{courseId}', [App\Http\Controllers\StudentCourseController::class, 'showByCourseId']);


// Tasks Routes

// Grade Routes

// Announcement Routes
