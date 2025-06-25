<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectStudent extends Model
{
    protected $table = 'subject_students';
    
    public $timestamps = false;

    protected $fillable = [
        'subjectId',
        'studentId',
        'tenantId',
        'isActive',
        'created',
        'updated',
        'deleted',
    ];

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'deleted' => 'datetime',
    ];
}
