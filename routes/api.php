<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GradeController;

// API Routes

// Student Course Routes

const STUDENT_COURSE_ID_ROUTE = '/student-courses/{id}';
const TASK_ID_ROUTE = '/tasks/{id}';
const GRADE_ID_ROUTE = '/grades/{id}';

Route::get('/student-courses', [StudentCourseController::class, 'index']);
Route::get(STUDENT_COURSE_ID_ROUTE, [StudentCourseController::class, 'show']);
Route::post('/student-courses', [StudentCourseController::class, 'store']);
Route::put(STUDENT_COURSE_ID_ROUTE, [StudentCourseController::class, 'update']);
Route::delete(STUDENT_COURSE_ID_ROUTE, [StudentCourseController::class, 'destroy']);
Route::get('/student-courses/student/{studentId}', [StudentCourseController::class, 'showByStudentId']);
Route::get('/student-courses/course/{courseId}', [StudentCourseController::class, 'showByCourseId']);

// Tasks Routes

Route::get('/tasks', [TaskController::class, 'index']);
Route::get(TASK_ID_ROUTE, [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put(TASK_ID_ROUTE, [TaskController::class, 'update']);
Route::delete(TASK_ID_ROUTE, [TaskController::class, 'destroy']);

// Grade Routes

Route::get('/grades', [GradeController::class, 'index']);
Route::get(GRADE_ID_ROUTE, [GradeController::class, 'show']);
Route::post('/grades', [GradeController::class, 'store']);
Route::put(GRADE_ID_ROUTE, [GradeController::class, 'update']);
Route::delete(GRADE_ID_ROUTE, [GradeController::class, 'destroy']);
Route::get('/grades/task/{taskId}', [GradeController::class, 'showByTaskId']);
Route::get('/grades/student/{studentId}', [GradeController::class, 'showByStudentId']);
Route::get('/grades/task/{taskId}/student/{studentId}', [GradeController::class, 'showByTaskAndStudentId']);

// Announcement Routes
