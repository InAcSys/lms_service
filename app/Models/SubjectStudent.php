<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectStudent extends Model
{
    protected $table = 'subject_students';

    protected $fillable = [
        'SubjectId',
        'StudentId',
        'TenantId',
        'IsActive',
        'Created',
        'Updated',
        'Deleted',
    ];
}
