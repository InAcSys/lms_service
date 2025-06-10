<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $table = "student_course";

    protected $fillable = [
        'courseId',
        'studentId',
        'tenantId',
        'isActive',
    ];

    protected $casts = [
        'courseId' => 'string',
        'studentId' => 'string',
        'tenantId' => 'string',
        'isActive' => 'boolean',
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';
}
